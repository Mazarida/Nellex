<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2018 ALTASIB
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

use ALTASIB\Review\Internals\ReviewTable;
use ALTASIB\Review\Review;
use Bitrix\Main\UI\PageNavigation;

\Bitrix\Main\Loader::includeModule("altasib.review");

IncludeModuleLangFile(__FILE__);

$ModulePermissions = $APPLICATION->GetGroupRight("altasib.review");
if ($ModulePermissions == "D") {
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}

$sTableID = "tbl_altasib_review_list";
$oSort = new CAdminSorting($sTableID, "ID", "DESC");
$lAdmin = new CAdminUiList($sTableID, $oSort);

$filterFields = array(
	array(
		"id" => "FIND",
		"name" => GetMessage("ALTASIB_REVIEW_F_AUTHOR"),
		"filterable" => "",
		"default" => true
	),
	array(
		"id" => "POST_DATE",
		"name" => GetMessage("ALTASIB_REVIEW_F_CREATE_PERIOD"),
		"filterable" => "",
		"default" => true,
		"type" => "date",
	),
	array(
		"id" => "APPROVED",
		"name" => GetMessage("ALTASIB_REVIEW_F_APPROVED"),
		"type" => "list",
		"items" => array(
			"Y" => GetMessage("MAIN_YES"),
			"N" => GetMessage("MAIN_NO")
		),
		"filterable" => ""
	),
	array(
		"id" => "ELEMENT_ID",
		"name" => GetMessage("ALTASIB_REVIEW_F_ELEMENT_ID"),
		"filterable" => "",
		"default" => true
	),
	array(
		"id" => "TITLE",
		"name" => GetMessage("ALTASIB_REVIEW_F_TITLE"),
		"filterable" => "",
		"default" => true
	),
	array(
		"id" => "ID",
		"name" => 'ID',
		"filterable" => "",
		"default" => true
	),
);
$arFilter = array();

$lAdmin->AddFilter($filterFields, $arFilter);
$filterOption = new Bitrix\Main\UI\Filter\Options($sTableID);
$filterData = $filterOption->getFilter($filterFields);

if (!empty($filterData["FIND"])) {
	$arFilter[0] = Array(
		"LOGIC" => "OR",
		Array("AUTHOR_EMAIL" => $filterData["FIND"]),
		Array("AUTHOR_NAME" => $filterData["FIND"]),
		Array("USER_ID" => $filterData["FIND"]),
		Array("USER_NAME" => $filterData["FIND"]),
		Array("USER_LAST_NAME" => $filterData["FIND"]),
		Array("USER_LOGIN" => $filterData["FIND"]),
		Array("USER_EMAIL" => $filterData["FIND"]),
	);

}

if ($lAdmin->EditAction()) {
	foreach ($FIELDS as $ID => $arFields) {
		if (!$lAdmin->IsUpdated($ID)) {
			continue;
		}
		$ID = IntVal($ID);
		$Review = new aReview;
		if (!isset($arFields['ELEMENT_ID'])) {
			$arFields['ELEMENT_ID'] = aReview::GetElementIdById($ID);
		}

		if (!$Review->Update($ID, $arFields)) {
			$lAdmin->AddUpdateError("ID:" . $ID . " - " . $Review->LAST_ERROR, $ID);
		}
	}
}

if ($arID = $lAdmin->GroupAction()) {
	if ($_REQUEST['action_target'] == 'selected') {
		$rsUniqData = ReviewTable::query()
			->setFilter($arFilter)
			->exec();
		while ($arRes = $rsUniqData->fetch()) {
			$arID[] = $arRes;
		}
	}
	foreach ($arID as $ID) {
		if (strlen($ID) <= 0) {
			continue;
		}

		switch ($_REQUEST['action']) {
			case "delete":
				ReviewTable::delete($ID);
				break;
			case "approve":
				Review::setApproved($ID, true);
				break;
			case "hide":
				Review::setApproved($ID, false);
				break;
		}
	}
}
$arSite = array();
$dataSites = \Bitrix\Main\SiteTable::getList();
while ($dataSite = $dataSites->fetch()) {
	$arSite[$dataSite['LID']] = $dataSite;
}

if (isset($arFilter["FIND"])) {
	unset($arFilter["FIND"]);
}

$nav = new PageNavigation("pages-altasib-review");
$nav->setPageSize($lAdmin->getNavSize());
$nav->initFromUri();

$params = array(
	'filter' => $arFilter,
	'order' => array($by => $order),
	'select' => array(
		'*',
		'USER_LOGIN' => 'USER.LOGIN',
		'USER_NAME' => 'USER.NAME',
		'USER_EMAIL' => 'USER.EMAIL',
		'USER_LAST_NAME' => 'USER.LAST_NAME'
	),
	'count_total' => true,
	'offset' => $nav->getOffset()
);
if ($_REQUEST["mode"] !== "excel") {
	$params['limit'] = $nav->getLimit();
}

$rsData = ReviewTable::getList($params);

$nav->setRecordCount($rsData->getCount());
$lAdmin->setNavigation($nav, GetMessage("ALTASIB_REVIEW_ADMIN_NAV"), false);

$rsData = new CAdminResult($rsData, $sTableID);

$arHeaders = array(
	array("id" => "ID", "content" => "ID", "sort" => "ID", "default" => false),
	array(
		"id" => "ELEMENT_ID",
		"content" => GetMessage("ALTASIB_REVIEW_HEAD_ELEMENT_ID"),
		"sort" => "ELEMENT_ID",
		"default" => true
	),
	array(
		"id" => "APPROVED",
		"content" => GetMessage("ALTASIB_REVIEW_HEAD_APPROVED"),
		"sort" => "APPROVED",
		"default" => true,
		"align" => "center"
	),
	array(
		"id" => "AUTHOR_NAME",
		"content" => GetMessage("ALTASIB_REVIEW_HEAD_AUTHOR_NAME"),
		"sort" => "AUTHOR_NAME",
		"default" => true
	),
	array(
		"id" => "AUTHOR_EMAIL",
		"content" => GetMessage("ALTASIB_REVIEW_HEAD_AUTHOR_EMAIL"),
		"sort" => "AUTHOR_EMAIL",
		"default" => true
	),
	array(
		"id" => "POST_DATE",
		"content" => GetMessage("ALTASIB_REVIEW_HEAD_POST_DATE"),
		"sort" => "POST_DATE",
		"default" => true
	),
	array("id" => "MESSAGE_PLUS", "content" => GetMessage("ALTASIB_REVIEW_HEAD_MESSAGE_PLUS"), "default" => true),
	array("id" => "MESSAGE_MINUS", "content" => GetMessage("ALTASIB_REVIEW_HEAD_MESSAGE_MINUS"), "default" => true),
	array("id" => "MESSAGE", "content" => GetMessage("ALTASIB_REVIEW_HEAD_MESSAGE"), "default" => true),
	array("id" => "TITLE", "content" => GetMessage("ALTASIB_REVIEW_HEAD_TITLE"), "default" => false),
	array("id" => "AUTHOR_IP", "content" => GetMessage("ALTASIB_REVIEW_HEAD_IP"), "default" => false),
);
$lAdmin->AddHeaders($arHeaders);
$arVisibleColumns = $lAdmin->GetVisibleHeaderColumns();
$arIBlockElementCache = Array();

while ($arRes = $rsData->NavNext(true, "f_")) {
	$row =& $lAdmin->AddRow($f_ID, $arRes);
	$row->AddViewField("APPROVED", GetMessage("ALTASIB_REVIEW_APPROVED_" . $arRes["APPROVED"]));

	if ($arRes["USER_ID"] > 0) {
		$row->AddViewField("AUTHOR_NAME",
			"[<a href='/bitrix/admin/user_edit.php?lang=" . LANG . "&ID=" . $arRes["USER_ID"] . "' target='_blank'>" . $arRes["USER_ID"] . "</a>] (" . $arRes["USER_LOGIN"] . ") " . $arRes["USER_NAME"] . " " . $arRes["USER_LAST_NAME"]);
		$row->AddViewField("AUTHOR_EMAIL", $arRes["USER_EMAIL"]);
	} else {
		$row->AddEditField("AUTHOR_NAME", $arRes["AUTHOR_NAME"]);
		$row->AddEditField("AUTHOR_EMAIL", htmlspecialcharsEx($arRes["AUTHOR_EMAIL"]));
	}


	$row->AddCheckField("APPROVED");
	$row->AddCheckField("DELETED");

	$showField = "";
	if (in_array("MESSAGE_PLUS", $arVisibleColumns)) {
		$showField = '<textarea rows="10" cols="50" name="FIELDS[' . $f_ID . '][MESSAGE_PLUS]">' . htmlspecialcharsEx($arRes["MESSAGE_PLUS"]) . '</textarea>';
	}
	$row->AddEditField("MESSAGE_PLUS", $showField);

	$showField = "";
	if (in_array("MESSAGE_MINUS", $arVisibleColumns)) {
		$showField = '<textarea rows="10" cols="50" name="FIELDS[' . $f_ID . '][MESSAGE_MINUS]">' . htmlspecialcharsEx($arRes["MESSAGE_MINUS"]) . '</textarea>';
	}
	$row->AddEditField("MESSAGE_MINUS", $showField);

	$showField = "";
	if (in_array("MESSAGE", $arVisibleColumns)) {
		$showField = '<textarea rows="10" cols="50" name="FIELDS[' . $f_ID . '][MESSAGE]">' . htmlspecialcharsEx($arRes["MESSAGE"]) . '</textarea>';
	}
	$row->AddEditField("MESSAGE", $showField);
	$row->AddViewField("TITLE", $arRes["TITLE"]);
	$row->AddEditField("TITLE", $arRes["TITLE"]);

	$showField = "";
	if (in_array("ELEMENT_ID", $arVisibleColumns) && CModule::IncludeModule("iblock")) {
		if (!array_key_exists($arRes["ELEMENT_ID"], $arIBlockElementCache)) {
			$arIBlockElementCache[$arRes["ELEMENT_ID"]] = Array("NAME" => "", "DETAIL_PAGE_URL" => "");
			$obIBlockElement = CIBlockElement::GetList(Array(), Array("ID" => intval($arRes["ELEMENT_ID"])), false,
				false, Array("DETAIL_PAGE_URL", "ID", "IBLOCK_ID", "NAME"));
			if ($arIBlockElement = $obIBlockElement->GetNext()) {
				$arIBlockElementCache[$arRes["ELEMENT_ID"]] = $arIBlockElement;
			}
		}
		$arIBlockElement = $arIBlockElementCache[$arRes["ELEMENT_ID"]];

		$server_name = '';
		if (strlen(trim($arSite[$arRes['SITE_ID']]['SERVER_NAME'])) > 0) {
			$server_name = (CMain::IsHTTPS()) ? "https://" . $arSite[$arRes['SITE_ID']]['SERVER_NAME'] : "http://" . $arSite[$arRes['SITE_ID']]['SERVER_NAME'];
		}

		$showField = '<a href="' . $server_name . $arIBlockElement["DETAIL_PAGE_URL"] . '#review_' . $f_ID . '" target="_blank">' . htmlspecialcharsEx($arIBlockElement["NAME"]) . '</a>';
	}
	$row->AddField("ELEMENT_ID", $showField);

	$arActions = Array();
	if ($arRes["APPROVED"] <> "Y") {
		$arActions[] = array(
			"ICON" => "list",
			"TEXT" => GetMessage("ALTASIB_REVIEW_PUBLISH"),
			"ACTION" => $lAdmin->ActionDoGroup($f_ID, "approve", 'ID=' . $f_ID)
		);
	} else {
		$arActions[] = array(
			"ICON" => "list",
			"TEXT" => GetMessage("ALTASIB_REVIEW_HIDE"),
			"ACTION" => $lAdmin->ActionDoGroup($f_ID, "hide", 'ID=' . $f_ID)
		);
	}

	$arActions[] = array("SEPARATOR" => true);
	$arActions[] = array(
		"ICON" => "delete",
		"TEXT" => GetMessage("MAIN_DELETE"),
		"ACTION" => "if(confirm('" . GetMessage("ALTASIB_REVIEW_DEL_CONF") . "')) " . $lAdmin->ActionDoGroup($f_ID,
				"delete", 'ID=' . $f_ID)
	);
	$row->AddActions($arActions);
}

$lAdmin->AddFooter(array(
	array("title" => GetMessage("MAIN_ADMIN_LIST_SELECTED"), "value" => $rsData->SelectedRowsCount()),
	array("counter" => true, "title" => GetMessage("MAIN_ADMIN_LIST_CHECKED"), "value" => "0"),
));

$lAdmin->AddGroupActionTable(Array(
	"delete" => GetMessage("MAIN_ADMIN_LIST_DELETE"),
	"approve" => GetMessage("ALTASIB_REVIEW_PUBLISH"),
	"hide" => GetMessage("ALTASIB_REVIEW_HIDE"),
));


$aContext = array(
	Array(
		"TEXT" => GetMessage("ALTASIB_REVIEW_UP_BUTTON"),
		"TITLE" => GetMessage("ALTASIB_REVIEW_UP_BUTTON"),
		"ICON" => "btn_list",
		"LINK" => '/bitrix/admin/altasib_review_section.php?lang=' . LANG,
	)
);


$lAdmin->AddAdminContextMenu($aContext);
$lAdmin->CheckListMode();
$APPLICATION->SetTitle(GetMessage("ALTASIB_REVIEW_ADMIN_LIST_TITLE"));
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php"); // Second prolog
$lAdmin->DisplayFilter($filterFields);
$lAdmin->DisplayList();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");