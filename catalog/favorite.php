<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Избранное");

// Массив ID товаров из списка избранных товаров
$wish_list = isset($_COOKIE['wishlist']) && !empty($_COOKIE['wishlist']) ? explode(',', $_COOKIE['wishlist']) : array();
?>

	<h1 class="page-name"><?$APPLICATION->ShowTitle(false)?></h1>

	<div class="flex-row content__wrapper-shop">
		<?if (count($wish_list)):?>
			<?
			// Отфильтровать товары из списка избранных
			global $arrFilter;
			$GLOBALS['arrFilter'] = array("IBLOCK_ID" => IBLOCK_ID__CATALOG, "ID" => $wish_list, "ACTIVE_DATE" => "Y", 'ACTIVE' => 'Y');

			$APPLICATION->IncludeComponent("bitrix:catalog.smart.filter", "main", Array(
				"AJAX_MODE" => "Y",	// Включить режим AJAX
				"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
				"AJAX_OPTION_HISTORY" => "Y",	// Включить эмуляцию навигации браузера
				"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
				"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
				"CACHE_GROUPS" => "Y",	// Учитывать права доступа
				"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
				"CACHE_TYPE" => "A",	// Тип кеширования
				"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
				"DISPLAY_ELEMENT_COUNT" => "N",	// Показывать количество
				"FILTER_NAME" => "arrFilter",	// Имя выходящего массива для фильтрации
				"FILTER_VIEW_MODE" => "vertical",	// Вид отображения
				"HIDE_NOT_AVAILABLE" => "N",	// Не отображать товары, которых нет на складах
				"IBLOCK_ID" => IBLOCK_ID__CATALOG,	// Инфоблок
				"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
				"INSTANT_RELOAD" => "Y", // Мгновенная фильтрация при включенном AJAX
				"PAGER_PARAMS_NAME" => "arrPager",	// Имя массива с переменными для построения ссылок в постраничной навигации
				"POPUP_POSITION" => "right",	// Позиция для отображения всплывающего блока с информацией о фильтрации
				"PRICE_CODE" => array(	// Тип цены
					0 => "RETAIL_PRICE",
					1 => "WHOLESALE_PRICE",
				),
				"SAVE_IN_SESSION" => "N",	// Сохранять установки фильтра в сессии пользователя
				"SECTION_CODE" => "",	// Код раздела
				"SECTION_CODE_PATH" => "",	// Путь из символьных кодов раздела
				"SECTION_DESCRIPTION" => "-",	// Описание
				"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела инфоблока
				"SECTION_TITLE" => "-",	// Заголовок
				"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
				"SEF_RULE" => "/catalog/favorite/filter/#SMART_FILTER_PATH#/apply/",	// Правило для обработки
				"SHOW_ALL_WO_SECTION" => "Y",	// Показывать все элементы, если не указан раздел
				"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],	// Блок ЧПУ умного фильтра
				"TEMPLATE_THEME" => "blue",	// Цветовая тема
				"XML_EXPORT" => "N",	// Включить поддержку Яндекс Островов
			),
				false
			);
			?>

			<div class="flex-row col__cata-prods">
				<?
				$APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_DIR."include/catalog/catalog_section.php",
					"EDIT_TEMPLATE" => ""
				),
					false,
					array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => "")
				);
				?>
			</div>
		<?endif;?>
	</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>