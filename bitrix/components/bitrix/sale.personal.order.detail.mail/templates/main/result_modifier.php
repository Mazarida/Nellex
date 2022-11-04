<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$rsUser = CUser::GetList(($by = "ID"), ($order = "asc"), array("ID" => $arResult["USER"]["ID"]), array("SELECT" => array("UF_INN")));
$arUser = $rsUser->GetNext();
$arResult["USER"]["INN"] = $arUser["UF_INN"];
//PR($arUser);

if ($arResult['PERSON_TYPE']['ID'] == 2) { // юр. лицо
    $arResult['DELIVERY_ZIP'] = $arResult['ORDER_PROPS'][7]['VALUE'];
    $arResult['DELIVERY_CITY'] = $arResult['ORDER_PROPS'][8]['VALUE'];
    $arResult['DELIVERY_ADDRESS'] = $arResult['ORDER_PROPS'][9]['VALUE'];
} else {
    $arResult['DELIVERY_ZIP'] = $arResult['ORDER_PROPS'][3]['VALUE'];
    $arResult['DELIVERY_CITY'] = $arResult['ORDER_PROPS'][4]['VALUE'];
    $address = array();
    if ($arResult['ORDER_PROPS'][5]['VALUE']) {
        $address[] = $arResult['ORDER_PROPS'][5]['VALUE'];
    }
    if ($arResult['ORDER_PROPS'][6]['VALUE']) {
        $address[] = 'д. ' . $arResult['ORDER_PROPS'][6]['VALUE'];
    }
    if ($arResult['ORDER_PROPS'][7]['VALUE']) {
        $address[] = 'корп. ' . $arResult['ORDER_PROPS'][7]['VALUE'];
    }
    if ($arResult['ORDER_PROPS'][8]['VALUE']) {
        $address[] = 'кв. ' . $arResult['ORDER_PROPS'][8]['VALUE'];
    }
    $arResult['DELIVERY_ADDRESS'] = implode(', ', $address);
}
