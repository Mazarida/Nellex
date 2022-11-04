<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Оплата заказа");
?>

<?$APPLICATION->IncludeComponent("bitrix:sale.order.payment", "", Array());?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>