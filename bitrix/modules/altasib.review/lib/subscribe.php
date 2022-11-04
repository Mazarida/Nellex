<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2017 ALTASIB
 */
namespace ALTASIB\Review;

use ALTASIB\Review\Internals\ReviewTable;
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use ALTASIB\Review\Internals\SubscribeTable;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Mail;

Loc::loadMessages(__FILE__);

class Subscribe
{
	public static function isSubscribe($elementId, $email)
	{
		$elementId = (int)$elementId;

		if ($elementId == 0 || !\check_email($email)) {
			return false;
		}

		if (Internals\SubscribeTable::getRow(['filter' => ['ELEMENT_ID' => $elementId, 'EMAIL' => $email]])) {
			return true;
		}

		return false;
	}

	public static function sendEmail($id, $eventFields = array())
	{
		$id = (int)$id;
		if ($id == 0) {
			return false;
		}

		$siteID = SITE_ID;
		if (count($eventFields) == 0) {
			$eventFields = Array();
			$reviewData = ReviewTable::query()
				->where('ID', '=', $id)
				->addSelect('*')
				->addSelect('USER')
				->exec()
				->fetch();
			if ($reviewData) {
				$arEventFields = $reviewData;
				$siteID = $reviewData["SITE_ID"];
				$arEventFields["REVIEW_ID"] = $reviewData['ID'];
				$arElementInfo = Tools::getElementInfo($reviewData["ELEMENT_ID"]);
				$arEventFields["IBLOCK_ELEMENT_ID"] = $reviewData["ELEMENT_ID"];
				if ($arElementInfo) {
					$arEventFields["IBLOCK_ELEMENT_NAME"] = $arElementInfo["NAME"];
					$arEventFields["IBLOCK_ELEMENT_IBLOCK_ID"] = $arElementInfo["IBLOCK_ID"];
					$arEventFields["IBLOCK_ELEMENT_DETAIL_PAGE_URL"] = $arElementInfo["DETAIL_PAGE_URL"];
				}
				$arEventFields["POST_URL"] = $arEventFields["IBLOCK_ELEMENT_DETAIL_PAGE_URL"] . "#review" . $id;

				if ($reviewData["ALTASIB_REVIEW_REVIEW_USER_ID"] > 0) {
					$arEventFields["AUTHOR"] = $reviewData["ALTASIB_REVIEW_REVIEW_USER_NAME"];
					$arEventFields["AUTHOR_EMAIL"] = $reviewData["ALTASIB_REVIEW_REVIEW_USER_EMAIL"];
				} else {
					$arEventFields["AUTHOR"] = $reviewData["AUTHOR_NAME"];
					$arEventFields["AUTHOR_EMAIL"] = $reviewData["AUTHOR_EMAIL"];
				}

				$arEventFields["MESSAGE_BODY"] = "";
				if (strlen($reviewData['MESSAGE_PLUS']) > 0) {
					$arEventFields["MESSAGE_BODY"] .= Loc::getMessage("ALTASIB_REVIEW_SUBSCRIBE_PLUS") . Mail\Mail::getMailEol() . $reviewData['MESSAGE_PLUS'] . Mail\Mail::getMailEol();
				}

				if (strlen($reviewData['MESSAGE_MINUS']) > 0) {
					$arEventFields["MESSAGE_BODY"] .= Loc::getMessage("ALTASIB_REVIEW_SUBSCRIBE_MINUS") . Mail\Mail::getMailEol() . $reviewData['MESSAGE_MINUS'] . Mail\Mail::getMailEol();
				}

				if (strlen($reviewData['MESSAGE']) > 0) {
					$arEventFields["MESSAGE_BODY"] .= Loc::getMessage("ALTASIB_REVIEW_SUBSCRIBE_COMMENT") . Mail\Mail::getMailEol() . $reviewData['MESSAGE'];
				}
			}
		}

		if (strlen($eventFields["EMAIL_FROM"]) == 0) {
			$eventFields["EMAIL_FROM"] = Option::get("altasib.review", "email_from");
		}

		$db_events = \GetModuleEvents("altasib.review", "OnBeforeSendSubMail");
		while ($arEvent = $db_events->Fetch()) {
			if (\ExecuteModuleEventEx($arEvent, array(&$eventFields)) === false) {
				return false;
			}
		}

		$obS = SubscribeTable::getList(array('filter' => array("ELEMENT_ID" => $eventFields["IBLOCK_ELEMENT_ID"])));
		while ($arS = $obS->fetch()) {
			$eventFields["EMAIL"] = $arS["EMAIL"];
			\CEvent::Send("ALTASIB_REVIEW_ADD", $siteID, $eventFields, "N");
		}

		ReviewTable::update($id, array('IS_SEND' => 'Y'));
	}
}