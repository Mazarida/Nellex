<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
IncludeModuleLangFile(__FILE__);

global $APPLICATION;
$RIGHT = $APPLICATION->GetGroupRight("altasib.review");
if($RIGHT=="D")
        $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

$APPLICATION->SetTitle(GetMessage("ALTASIB_REVIEW_INDEX_TITLE"));
if($_REQUEST["mode"] == "list")
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_js.php");
else
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$adminPage->ShowSectionIndex("altasib_review", "altasib_review");

if($_REQUEST["mode"] == "list")
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_js.php");
else
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");
?>
