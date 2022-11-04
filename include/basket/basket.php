<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/**
 * @global CMain $APPLICATION
 */

//include_once("action_basket.php");

$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "ma_emotion", Array(
	"ACTION_VARIABLE" => "basketAction",	// Название переменной действия
	"ADDITIONAL_PICT_PROP_1" => "-",	// Дополнительная картинка [Каталог]
	"AJAX_MODE_CUSTOM" => "Y",
	"AUTO_CALCULATION" => "Y",	// Автопересчет корзины
	"BASKET_IMAGES_SCALING" => "adaptive",	// Режим отображения изображений товаров
	"COLUMNS_LIST_EXT" => array(	// Выводимые колонки
		0 => "PREVIEW_PICTURE",
		1 => "DISCOUNT",
		2 => "DELETE",
		//3 => "TYPE",
		3 => "SUM",
		4 => "PROPERTY_COLOR",
		5 => "PROPERTY_SIZE",
	),
	"COLUMNS_LIST_MOBILE" => array(	// Колонки, отображаемые на мобильных устройствах
		0 => "PREVIEW_PICTURE",
		1 => "DISCOUNT",
		2 => "DELETE",
		//3 => "TYPE",
		3 => "SUM",
		4 => "PROPERTY_COLOR",
		5 => "PROPERTY_SIZE",
	),
	"COMPATIBLE_MODE" => "Y",	// Включить режим совместимости
	"CORRECT_RATIO" => "Y",	// Автоматически рассчитывать количество товара кратное коэффициенту
	"DEFERRED_REFRESH" => "N",	// Использовать механизм отложенной актуализации данных товаров с провайдером
	"DISCOUNT_PERCENT_POSITION" => "bottom-right",
	"DISPLAY_MODE" => "extended",	// Режим отображения корзины
	"EMPTY_BASKET_HINT_PATH" => "/",	// Путь к странице для продолжения покупок
	"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
	"GIFTS_CONVERT_CURRENCY" => "N",
	"GIFTS_HIDE_BLOCK_TITLE" => "N",
	"GIFTS_HIDE_NOT_AVAILABLE" => "N",
	"GIFTS_MESS_BTN_BUY" => "Выбрать",
	"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
	"GIFTS_PAGE_ELEMENT_COUNT" => "4",
	"GIFTS_PLACE" => "BOTTOM",
	"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
	"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
	"GIFTS_SHOW_OLD_PRICE" => "N",
	"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
	"HIDE_COUPON" => "Y",	// Спрятать поле ввода купона
	"LABEL_PROP" => "",	// Свойства меток товара
	"PATH_TO_ORDER" => "/personal/order/make/",	// Страница оформления заказа
	"PRICE_DISPLAY_MODE" => "Y",	// Отображать цену в отдельной колонке
	"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
	"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",	// Порядок отображения блоков товара
	"QUANTITY_FLOAT" => "N",	// Использовать дробное значение количества
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SHOW_DISCOUNT_PERCENT" => "N",	// Показывать процент скидки рядом с изображением
	"SHOW_FILTER" => "N",	// Отображать фильтр товаров
	"SHOW_RESTORE" => "N",	// Разрешить восстановление удалённых товаров
	"TEMPLATE_THEME" => "blue",	// Цветовая тема
	"TOTAL_BLOCK_DISPLAY" => array(	// Отображение блока с общей информацией по корзине
		0 => "top",
	),
	"USE_DYNAMIC_SCROLL" => "Y",	// Использовать динамическую подгрузку товаров
	"USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
	"USE_GIFTS" => "N",	// Показывать блок "Подарки"
	"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
	"USE_PRICE_ANIMATION" => "Y",	// Использовать анимацию цен
),
	false
);