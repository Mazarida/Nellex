<?
define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/**
 * @global CMain $APPLICATION
 */

if (\Bitrix\Main\Loader::includeModule("sale") && 0 < intval($_REQUEST["id"])) {
    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "PRODUCT_ID" => $_REQUEST["id"],
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array("ID")
    )->Fetch();

    if (!empty($dbBasketItems)) {
        CSaleBasket::Delete($dbBasketItems["ID"]);
        //echo '<script>console.log("ID: '.$dbBasketItems["ID"].'")</script>';
    }

    $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => SITE_DIR."include/basket/basket.php",
        "EDIT_TEMPLATE" => ""
    ),
        false,
        array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => "")
    );
}