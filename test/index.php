<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Тестовая страница");

if (!$USER->IsAdmin()) {
	LocalRedirect(SITE_DIR);
}
?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
