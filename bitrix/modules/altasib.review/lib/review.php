<?php

/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2018 ALTASIB
 */
namespace ALTASIB\Review;

use \ALTASIB\Review\Internals\ReviewTable;
use \ALTASIB\Review\Internals\UserTable;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;

class Review
{
	public static function setApproved($id, $show = true)
	{
		$id = (int)$id;
		if ($id == 0) {
			return false;
		}

		$reviewData = ReviewTable::query()
			->where('ID', '=', $id)
			->addSelect('ID')
			->addSelect('APPROVED')
			->addSelect('USER_ID')
			->addSelect('ELEMENT_ID')
			->exec()
			->fetch();
		if ($reviewData) {
			$isShowed = $reviewData['APPROVED'] == 'Y';
			if ($show == $isShowed) {
				return true;
			}

			$result = ReviewTable::update($id, array('APPROVED' => ($show ? 'Y' : 'N')));
			if ($result->isSuccess()) {
				if ($reviewData['USER_ID'] > 0) {
					$cnt = ReviewTable::count(array("USER_ID" => $reviewData['USER_ID']));
					$tcnt = (int)Option::get('altasib.review', 'transfer', 5);

					if ($cnt > $tcnt) {
						$reviewUserFileds = array(
							'ALLOW_POST' => 'Y',
							'MODERATE_POST' => 'N',
						);

						if ($dataUser = UserTable::getRow([
							'filter' => ['USER_ID' => $reviewData['USER_ID']],
							'select' => ['ID']
						])
						) {
							UserTable::update($dataUser["ID"], $reviewUserFileds);
						} else {
							$reviewUserFileds["USER_ID"] = $reviewData['USER_ID'];
							UserTable::add($reviewUserFileds);
						}
					}
				}

				self::reIndex($id);
				\ALTASIB\Review\Tools::clearCache($reviewData['ELEMENT_ID']);
				if ($show == true) {
					if (!self::isSended($id)) {
						\ALTASIB\Review\Subscribe::sendEmail($id, array());
					}
				}
				return true;
			}
		}
		return false;
	}

	public static function reIndex($id)
	{
		$reviewData = ReviewTable::query()
			->where('ID', '=', $id)
			->addSelect('*')
			->exec()
			->fetch();
		if ($reviewData) {
			self::index($id, $reviewData, true);
		}
	}

	public static function index($id, $fileds, $bOverWrite = false)
	{
		if (Loader::includeModule("search") && Option::get("altasib.review", "indexing", "Y") == "Y") {

			$reviewData = ReviewTable::query()
				->where('ID', '=', $id)
				->addSelect('*')
				->exec()
				->fetch();

			if ($reviewData) {

				if (!isset($fileds["ELEMENT_ID"]) || (int)$fileds["ELEMENT_ID"] == 0) {
					$fileds["ELEMENT_ID"] = $reviewData["ELEMENT_ID"];
				}

				$arIblockElement = \ALTASIB\Review\Tools::getElementInfo($fileds["ELEMENT_ID"]);

				$arGroups = Array();

				if (isset($fileds["APPROVED"]) && $fileds["APPROVED"] != "Y") {
					$arGroups = \ALTASIB\Review\Tools::getModeratorGroups();
				}

				if (count($arGroups) == 0 && $fileds["APPROVED"] == "Y") {
					$arGroups = Array(2);
				}

				$arIndex = Array(
					"DATE_CHANGE" => $fileds["POST_DATE"],
					"LAST_MODIFIED" => $fileds["POST_DATE"],
					"TITLE" => GetMessage("ALTASIB_REVIEW_INDEX_MESS",
						Array("#ELEMENT_NAME#" => $arIblockElement["~NAME"])),
					"SITE_ID" => $reviewData["SITE_ID"],
					"PARAM1" => "",
					"PARAM2" => "",
					"BODY" => $fileds["MESSAGE_PLUS"] . "\n" . $fileds["MESSAGE_MINUS"] . "\n" . $fileds["MESSAGE"],
					"PERMISSIONS" => $arGroups,
					"URL" => $arIblockElement["~DETAIL_PAGE_URL"] . "#review" . $id
				);

				\CSearch::Index("altasib.review", $id, $arIndex, $bOverWrite);
			}
		}
	}

	/**
	 * @param $id integer
	 * @return bool
	 */
	public static function isSended($id)
	{
		$dataReview = ReviewTable::query()
			->where('ID', '=', $id)
			->addSelect('IS_SEND')
			->exec()
			->fetch();
		if ($dataReview['IS_SEND'] == 'Y') {
			return true;
		}

		return false;
	}

	public static function allowVote($id){
		global $USER, $APPLICATION;

		$id = (int)$id;
		if ($id == 0) {
			return false;
		}

		$sess = (Option::get("altasib.review", "VOTE_SESION", "N") == "Y");
		$cookie = (Option::get("altasib.review", "VOTE_COOKIE", "N") == "Y");
		$ip = (Option::get("altasib.review", "VOTE_IP", "N") == "Y");
		$user_id = (Option::get("altasib.review", "VOTE_USER_ID", "Y") == "Y");

		if ($sess) {
			if (is_array($_SESSION["REVIEW_VOTE"]) && in_array($id, $_SESSION["REVIEW_VOTE"])) {
				return false;
			}
		}

		if ($cookie) {
			$rv = $APPLICATION->get_cookie("REVIEW_VOTE");
			$arRV = explode(",", $rv);
			if (in_array($id, $arRV)) {
				return false;
			}
		}

		$filter = ['REVIEW_ID'=>$id];

		if ($ip) {
			$filter['IP'] = $_SERVER["REMOTE_ADDR"];
		}

		if ($user_id && !$USER->IsAuthorized()) {
			return false;
		} elseif ($user_id) {
			$filter['USER_ID'] = $USER->GetID();
		}

		if ($ip || $user_id) {
			if($data = Internals\Vote2ReviewTable::query()->setFilter($filter)->exec()->fetch()){
				return false;
			}
		}
		return true;
	}
}