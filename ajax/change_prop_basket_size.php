<?
define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/**
 * @global CMain $APPLICATION
 */

$id = 0 < intval($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
$prop_id = 0 < intval($_REQUEST["prop_id"]) ? intval($_REQUEST["prop_id"]) : 0;

if (\Bitrix\Main\Loader::includeModule("sale") && $id && $prop_id && !empty($_REQUEST["value"])) {
    $db_res = CSaleBasket::GetPropsList(
        array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
        array("BASKET_ID" => $id)
    );
    $arProps = array();
    while ($ar_res = $db_res->Fetch()) {
        $arProps[$ar_res["ID"]] = array(
            "NAME" => $ar_res["NAME"],
            "VALUE" => $ar_res["VALUE"],
            "CODE" => $ar_res["CODE"],
            "SORT" => $ar_res["SORT"],
        );
    }

    if (count($arProps)) {
        foreach ($arProps as $key => $item) {
            if ($key == $prop_id) {
                $arProps[$key]['VALUE'] = $_REQUEST["value"];
            }
        }

        $arFields = array(
            "PROPS" => $arProps,
        );

        CSaleBasket::Update($id, $arFields);
    }
    //echo '<script>console.log('.PR($arProps).')</script>';

//    $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
//        "AREA_FILE_SHOW" => "file",
//        "PATH" => SITE_DIR."include/basket/basket.php",
//        "EDIT_TEMPLATE" => ""
//    ),
//        false,
//        array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => "")
//    );
}