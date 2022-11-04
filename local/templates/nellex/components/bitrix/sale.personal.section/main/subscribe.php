<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;

if ($arParams['SHOW_SUBSCRIBE_PAGE'] !== 'Y') {
	LocalRedirect($arParams['SEF_FOLDER']);
}

//if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0) {
//	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
//}

$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_SUBSCRIBE_NEW"));

$APPLICATION->IncludeComponent('bitrix:catalog.product.subscribe.list', '', array(
	'SET_TITLE' => $arParams['SET_TITLE'],
	'DETAIL_URL' => $arParams['SUBSCRIBE_DETAIL_URL']
),
	$component
);

$APPLICATION->IncludeComponent("bitrix:subscribe.simple", "main", Array(
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"CACHE_TYPE" => "A",	// Тип кеширования
	"SET_TITLE" => $arParams['SET_TITLE'],	// Устанавливать заголовок страницы
	"SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
),
	$component
);