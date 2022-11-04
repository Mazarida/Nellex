<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2017 ALTASIB
 */
use ALTASIB\Review\Internals;
use Bitrix\Main\Loader;

$altasib_reviewWarningTmp = "";

if (Loader::includeModule("altasib.review") && check_bitrix_sessid()):
    $arAltasibReviewFields = array();

    if ($USER->IsAdmin()) {
        $arAltasibReviewFields["ALLOW_POST"] = (($altasib_review_ALLOW_POST == "Y") ? "Y" : "N");
        $arAltasibReviewFields["MODERATE_POST"] = (($altasib_review_MODERATE_POST == "Y") ? "Y" : "N");
    }

    $userData = Internals\UserTable::getRow(array(
        'select' => ['ID'],
        'filter' => array("USER_ID" => $ID)
    ));

    if ($userData) {
        Internals\ReviewTable::update($userData["ID"], $arAltasibReviewFields);
    } else {
        $arAltasibReviewFields["USER_ID"] = $ID;
        Internals\ReviewTable::add($arAltasibReviewFields);
    }
    $altasib_review_res = true;
endif;