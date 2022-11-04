<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2018 ALTASIB
 */
use Bitrix\Main;
use ALTASIB\Review\Internals;
use ALTASIB\Review\Review;

/**
 *
 * Class aReview
 * @deprecated
 */
class aReview extends aReviewMain
{
	const TABLE_NAME = 'altasib_review';
	const DB_TYPE = 'MYSQL';

	/**
	 * @param $ID
	 * @param bool $app
	 * @return bool
	 * @throws Exception
	 * @deprecated
	 */
	public static function SetApproved($ID, $app = true)
	{
		return Review::setApproved($ID, $app);
	}

	Function GetApproved($ID)
	{
		$ID = (int)$ID;
		if ($ID == 0) {
			return false;
		}

		$obReview = aReview::GetByID($ID, Array("APPROVED"));
		if ($arRes = $obReview->Fetch()) {
			return $arRes["APPROVED"] == "Y" ? true : false;
		}
		return null;
	}

	Function Count($filter = array())
	{
		$ob = Internals\ReviewTable::getList(array(
			'select' => array("CNT"),
			'filter' => $filter,
		));
		$arRes = $ob->fetch();
		return $arRes["CNT"];
	}

	/**
	 * @param $ID
	 * @return bool
	 * @deprecated
	 */
	public static function IsSend($ID)
	{
		return Review::isSended($ID);
	}

	/**
	 * compatibility
	 */

	public static function Delete($id)
	{
		Internals\ReviewTable::delete($id);
	}

	Function Add($arFields)
	{
		global $DB, $APPLICATION, $USER;

		if (is_set($arFields, "SUBSCRIBE") && $arFields["SUBSCRIBE"] != "Y") {
			$arFields["SUBSCRIBE"] = "N";
		}

		if (is_set($arFields, "APPROVED") && $arFields["APPROVED"] != "Y") {
			$arFields["APPROVED"] = "N";
		}

		if (is_set($arFields, "DELETED") && $arFields["DELETED"] != "Y") {
			$arFields["DELETED"] = "N";
		}

		if (!isset($arFields["AUTHOR_IP"]) || empty($arFields["AUTHOR_IP"])) {
			$arFields["AUTHOR_IP"] = $_SERVER["REMOTE_ADDR"];
		}

		if (!isset($arFields["SITE_ID"])) {
			$arFields["SITE_ID"] = SITE_ID;
		}

		if (!is_set($arFields, "POST_DATE")) {
			$arFields["POST_DATE"] = date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL", $arFields["SITE_ID"])),
				time());
		}

		$db_events = GetModuleEvents("altasib.review", "OnBeforeCommentAdd");
		while ($arEvent = $db_events->Fetch()) {
			if (ExecuteModuleEventEx($arEvent, array(&$arFields)) === false) {
				$ex = $APPLICATION->GetException();
				$arFields["RESULT_MESSAGE"] = $ex->GetString();
				return false;
			}
		}

		if (!$this->CheckFields($arFields)) {
			$Result = false;
			$arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;
		} elseif (!$GLOBALS["USER_FIELD_MANAGER"]->CheckFields("ALTASIB_REVIEW", 0, $arFields)) {
			$Result = false;
			$err = $APPLICATION->GetException();
			if (is_object($err)) {
				$this->LAST_ERROR .= str_replace("<br><br>", "<br>", $err->GetString() . "<br>");
			}
			$arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;
		} else {
			$arAllowTags = aReview::GetAllowTags();
			$parser = new aReviewTextParser();
			$parser->parser_nofollow = COption::GetOptionString("altasib.review", "ninf", "Y") == "Y" ? 'Y' : "N";
			$arFields["MESSAGE_HTML"] = $parser->convert($arFields["MESSAGE"], $arAllowTags);
			$arFields["MESSAGE_PLUS_HTML"] = $parser->convert($arFields["MESSAGE_PLUS"], $arAllowTags);
			$arFields["MESSAGE_MINUS_HTML"] = $parser->convert($arFields["MESSAGE_MINUS"], $arAllowTags);
			$arFields["REPLY_HTML"] = $parser->convert($arFields["REPLY"], $arAllowTags);

			$arInsert = $DB->PrepareInsert("altasib_review", $arFields, "altasib.review");
			$strSql = "INSERT INTO altasib_review(" . $arInsert[0] . ") VALUES(" . $arInsert[1] . ")";
			$DB->Query($strSql);
			$Result = $DB->LastID();

			if ($Result > 0) {
				$GLOBALS["USER_FIELD_MANAGER"]->Update("ALTASIB_REVIEW", $Result, $arFields);
				self::SetRating($arFields["ELEMENT_ID"]);
				foreach ($arFields["FILES"] as $FILE_ID) {
					$arFileFields = Array(
						"REVIEW_ID" => $Result,
						"FILE_ID" => $FILE_ID,
						"USER_ID" => $arFields["USER_ID"],
						"ELEMENT_ID" => $arFields["ELEMENT_ID"],
					);
					$arFileInsert = $DB->PrepareInsert("altasib_review_file", $arFileFields, "altasib.review");
					$strSql = "INSERT INTO altasib_review_file(" . $arFileInsert[0] . ") VALUES(" . $arFileInsert[1] . ")";
					$DB->Query($strSql);
				}

				//subs
				if ($arFields["SUBSCRIBE"] == "Y") {
					Internals\Subscribe::add($arFields["ELEMENT_ID"],
						($USER->IsAuthorized() ? $USER->GetEmail() : $arFields["AUTHOR_EMAIL"]));
				}

				//indexing
				aReview::Index($Result, $arFields);

				if ($arFields["APPROVED"] == "Y") {
					aReview::SendSubsEmail($Result);
				}
				self::ClearCache($arFields["ELEMENT_ID"]);
			}
		}
		return $Result;
	}

	Function SetRating($ELEMENT_ID)
	{
		global $DB, $USER, $APPLICATION;
		$ID = (int)$ELEMENT_ID;
		if ($ID == 0) {
			return false;
		}

		$sess = (COption::GetOptionString("altasib.review", "VOTE_SESION", "N") == "Y");
		$cookie = (COption::GetOptionString("altasib.review", "VOTE_COOKIE", "N") == "Y");
		$ip = (COption::GetOptionString("altasib.review", "VOTE_IP", "N") == "Y");
		if ($sess) {
			if (!is_array($_SESSION["REVIEW_RATING"])) {
				$_SESSION["REVIEW_RATING"] = Array();
			}

			$_SESSION["REVIEW_RATING"][] = $ID;
		}

		if ($cookie) {
			$rv = $APPLICATION->get_cookie("REVIEW_RATING");
			$arRV = explode(",", $rv);
			$arRV[] = $ID;
			$APPLICATION->set_cookie("REVIEW_RATING", implode(",", $arRV));
		}

		$USER_ID = $USER->GetID();
		if ($USER_ID > 0 || $ip) {
			$arInsert = $DB->PrepareInsert("altasib_review_rating2element",
				Array("USER_ID" => $USER_ID, "ELEMENT_ID" => $ID, "IP" => $_SERVER["REMOTE_ADDR"]), "altasib.review");
			$strSql = "INSERT INTO altasib_review_rating2element(" . $arInsert[0] . ") VALUES(" . $arInsert[1] . ")";
			$DB->Query($strSql);
		}
		return $res;
	}

	//old

	Function Update($ID, $arFields)
	{
		global $DB, $APPLICATION, $USER;

		$ID = (int)$ID;
		if ($ID == 0) {
			return false;
		}

		if (is_set($arFields, "APPROVED") && $arFields["APPROVED"] != "Y") {
			$arFields["APPROVED"] = "N";
		}

		if (!$this->CheckFields($arFields)) {
			$Result = false;
			$arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;
		} elseif (!$GLOBALS["USER_FIELD_MANAGER"]->CheckFields("ALTASIB_REVIEW", 0, $arFields)) {
			$Result = false;
			$err = $APPLICATION->GetException();
			if (is_object($err)) {
				$this->LAST_ERROR .= str_replace("<br><br>", "<br>", $err->GetString() . "<br>");
			}
			$arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;
		} else {
			if (array_key_exists("MESSAGE", $arFields) || array_key_exists("MESSAGE_PLUS",
					$arFields) || array_key_exists("MESSAGE_MINUS", $arFields) || array_key_exists("REPLY", $arFields)
			) {
				$arAllowTags = aReview::GetAllowTags();
				$parser = new aReviewTextParser();
				$parser->parser_nofollow = COption::GetOptionString("altasib.review", "ninf", "Y") == "Y" ? 'Y' : "N";
			}
			if (array_key_exists("MESSAGE", $arFields)) {
				$arFields["MESSAGE_HTML"] = $parser->convert($arFields["MESSAGE"], $arAllowTags);
			}
			if (array_key_exists("MESSAGE_PLUS", $arFields)) {
				$arFields["MESSAGE_PLUS_HTML"] = $parser->convert($arFields["MESSAGE_PLUS"], $arAllowTags);
			}
			if (array_key_exists("MESSAGE_MINUS", $arFields)) {
				$arFields["MESSAGE_MINUS_HTML"] = $parser->convert($arFields["MESSAGE_MINUS"], $arAllowTags);
			}
			if (array_key_exists("REPLY", $arFields)) {
				$arFields["REPLY_HTML"] = $parser->convert($arFields["REPLY"], $arAllowTags);
			}

			$strUpdate = $DB->PrepareUpdate("altasib_review", $arFields, "altasib.review");
			$strSql = "UPDATE altasib_review SET " . $strUpdate . " WHERE ID = " . $ID;
			$Result = $DB->Query($strSql, false, "FILE: " . __FILE__ . "<br> LINE: " . __LINE__);

			$GLOBALS["USER_FIELD_MANAGER"]->Update("ALTASIB_REVIEW", $ID, $arFields);

			$allow_upload_file = COption::GetOptionString("altasib.review", "allow_upload_file",
				"N") == "N" ? false : true;
			if ($Result && count($arFields["FILES"]) > 0) {
				$arFields["ELEMENT_ID"] = (int)$arFields["ELEMENT_ID"] > 0 ? $arFields["ELEMENT_ID"] : self::GetElementIdById($ID);
				$arFields["USER_ID"] = (int)$arFields["USER_ID"] > 0 ? $arFields["USER_ID"] : $USER->GetID(); //bug
				foreach ($arFields["FILES"] as $FILE_ID) {
					$arFileFields = Array(
						"REVIEW_ID" => $ID,
						"FILE_ID" => $FILE_ID,
						"USER_ID" => $arFields["USER_ID"],
						"ELEMENT_ID" => $arFields["ELEMENT_ID"],
					);
					$arFileInsert = $DB->PrepareInsert("altasib_review_file", $arFileFields, "altasib.review");
					$strSql = "INSERT INTO altasib_review_file(" . $arFileInsert[0] . ") VALUES(" . $arFileInsert[1] . ")";
					$DB->Query($strSql);
				}
			}
			self::Index($ID, $arFields, true);
			self::ClearCache(self::GetElementIdById($ID));
		}
		return $Result;
	}

	Function SetSend($ID)
	{
		global $DB;
		$ID = (int)$ID;
		if ($ID == 0) {
			return false;
		}

		$strSql = "UPDATE altasib_review SET IS_SEND='Y' WHERE ID=" . $ID;
		$DB->Query($strSql);
		return true;
	}

	Function Vote($ID, $plus = true)
	{
		global $DB, $USER, $APPLICATION;
		$ID = (int)$ID;
		if ($ID == 0) {
			return false;
		}

		$strSql = "UPDATE altasib_review SET " . ($plus ? 'VOTE_PLUS' : 'VOTE_MINUS') . " = " . ($plus ? 'VOTE_PLUS' : 'VOTE_MINUS') . " +1 WHERE ID=" . $ID;
		$res = $DB->Query($strSql, false, "FILE: " . __FILE__ . "<br> LINE: " . __LINE__);

		$sess = (COption::GetOptionString("altasib.review", "VOTE_SESION", "N") == "Y");
		$cookie = (COption::GetOptionString("altasib.review", "VOTE_COOKIE", "N") == "Y");
		$ip = (COption::GetOptionString("altasib.review", "VOTE_IP", "N") == "Y");
		if ($sess) {
			if (!is_array($_SESSION["REVIEW_VOTE"])) {
				$_SESSION["REVIEW_VOTE"] = Array();
			}

			$_SESSION["REVIEW_VOTE"][] = $ID;
		}

		if ($cookie) {
			$rv = $APPLICATION->get_cookie("REVIEW_VOTE");
			$arRV = explode(",", $rv);
			$arRV[] = $ID;
			$APPLICATION->set_cookie("REVIEW_VOTE", implode(",", $arRV));
		}

		if ($res) {
			$USER_ID = $USER->GetID();
			if ($USER_ID > 0 || $ip) {
				$arInsert = $DB->PrepareInsert("altasib_review_vote_to_review",
					Array("USER_ID" => $USER_ID, "REVIEW_ID" => $ID, "IP" => $_SERVER["REMOTE_ADDR"]),
					"altasib.review");
				$strSql = "INSERT INTO altasib_review_vote_to_review(" . $arInsert[0] . ") VALUES(" . $arInsert[1] . ")";
				$DB->Query($strSql);
			}
			self::ClearCacheFull($ID);
		}
		return $res;
	}

	/**
	 * @param $ID
	 * @return bool
	 * @deprecated 
	 */
	public static function AllowVote($ID)
	{
		return Review::allowVote($ID);
	}

	Function AllowSetRating($ELEMENT_ID)
	{
		global $DB, $USER, $APPLICATION;

		$ID = (int)$ELEMENT_ID;
		if ($ID == 0) {
			return false;
		}

		$sess = (COption::GetOptionString("altasib.review", "VOTE_SESION", "N") == "Y");
		$cookie = (COption::GetOptionString("altasib.review", "VOTE_COOKIE", "N") == "Y");
		$ip = (COption::GetOptionString("altasib.review", "VOTE_IP", "N") == "Y");
		$user_id = (COption::GetOptionString("altasib.review", "VOTE_USER_ID", "Y") == "Y");

		if ($sess) {
			if (is_array($_SESSION["REVIEW_RATING"]) && in_array($ID, $_SESSION["REVIEW_RATING"])) {
				return false;
			}
		}

		if ($cookie) {
			$rv = $APPLICATION->get_cookie("REVIEW_RATING");
			$arRV = explode(",", $rv);

			if (in_array($ID, $arRV)) {
				return false;
			}
		}

		$arSqlSearch = Array();
		if ($ip) {
			$arSqlSearch[] = "IP='" . $DB->ForSql($_SERVER["REMOTE_ADDR"]) . "'";
		}

		if ($user_id && !$USER->IsAuthorized()) {
			return false;
		} elseif ($user_id) {
			$arSqlSearch[] = "USER_ID=" . $USER->GetID();
		}

		if ($ip || $user_id) {
			$strSql = "SELECT 'x' FROM altasib_review_rating2element WHERE ELEMENT_ID=" . $ID . " AND ((" . implode(") OR (",
					$arSqlSearch) . "))";
			$res = $DB->Query($strSql);
			if ($res->Fetch()) {
				return false;
			}
		}
		return true;
	}

	Function GetVoteCount($ID)
	{
		global $DB;
		$ID = (int)$ID;
		if ($ID == 0) {
			return 0;
		}

		$strSql = "SELECT RM.VOTE_PLUS-RM.VOTE_MINUS as VOTE_SUMM FROM altasib_review RM WHERE ID=" . $ID;
		$res = $DB->Query($strSql);
		$arRes = $res->Fetch();
		return $arRes["VOTE_SUMM"];
	}

	Function CalculateRating($ELEMENT_ID)
	{
		global $DB;
		$ELEMENT_ID = (int)$ELEMENT_ID;
		if ($ELEMENT_ID == 0) {
			return 0;
		}

		$strSql = "SELECT SUM( RATING ) / count( ID ) AS CR FROM `altasib_review` WHERE APPROVED='Y' AND RATING >0 AND ELEMENT_ID =" . $ELEMENT_ID;
		$res = $DB->Query($strSql);
		if ($arRes = $res->Fetch()) {
			return number_format($arRes["CR"], 1);
		}
		return 0;
	}
}