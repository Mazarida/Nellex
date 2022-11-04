<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Товар");
?>

	<div class="content__wrapper-product">
		<?
		$APPLICATION->IncludeComponent("bitrix:catalog.element", "main", Array(
			"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
			"ADD_DETAIL_TO_SLIDER" => "Y",	// Добавлять детальную картинку в слайдер
			"ADD_ELEMENT_CHAIN" => "Y",	// Включать название элемента в цепочку навигации
			"ADD_PICT_PROP" => "MORE_PHOTO",
			"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
			"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
			"ADD_TO_BASKET_ACTION" => array(	// Показывать кнопки добавления в корзину и покупки
				0 => "BUY",
			),
			"ADD_TO_BASKET_ACTION_PRIMARY" => array(	// Выделять кнопки добавления в корзину и покупки
				0 => "BUY",
			),
			"BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
			"BASKET_URL" => PATH_TO_BASKET,	// URL, ведущий на страницу с корзиной покупателя
			"BLOG_EMAIL_NOTIFY" => "N",	// Уведомление по электронной почте
			"BLOG_URL" => "catalog_comments",	// Название блога латинскими буквами
			"BLOG_USE" => "Y",	// Использовать комментарии
			"BRAND_USE" => "N",	// Использовать компонент "Бренды"
			"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
			"CACHE_GROUPS" => "Y",	// Учитывать права доступа
			"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
//			"CACHE_TYPE" => "A",	// Тип кеширования
			"CACHE_TYPE" => "N",	// Тип кеширования
			"CHECK_SECTION_ID_VARIABLE" => "N",	// Использовать код группы из переменной, если не задан раздел элемента
			"COMPATIBLE_MODE" => "Y",	// Включить режим совместимости
			"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
			"DETAIL_PICTURE_MODE" => array(	// Режим показа детальной картинки
				0 => "MAGNIFIER",
			),
			"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
			"DISABLE_INIT_JS_IN_COMPONENT" => "N",	// Не подключать js-библиотеки в компоненте
			"DISCOUNT_PERCENT_POSITION" => "bottom-right",	// Расположение процента скидки
			"DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
			"DISPLAY_NAME" => "Y",	// Выводить название элемента
			"DISPLAY_PREVIEW_TEXT_MODE" => "E",	// Показ описания для анонса
			"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],	// Код элемента
			"ELEMENT_ID" => "",	// ID элемента
			"FB_USE" => "N",	// Использовать Facebook
			"FILE_404" => "",	// Страница для показа (по умолчанию /404.php)
			"GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",	// Текст заголовка "Подарки"
			"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",	// Скрыть заголовок "Подарки" в детальном просмотре
			"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",	// Количество элементов в блоке "Подарки" в строке в детальном просмотре
			"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",	// Текст метки "Подарка" в детальном просмотре
			"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",	// Текст заголовка "Товары к подарку"
			"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",	// Скрыть заголовок "Товары к подарку" в детальном просмотре
			"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",	// Количество элементов в блоке "Товары к подарку" в строке в детальном просмотре
			"GIFTS_MESS_BTN_BUY" => "Выбрать",	// Текст кнопки "Выбрать"
			"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",	// Показывать процент скидки
			"GIFTS_SHOW_IMAGE" => "Y",	// Показывать изображение
			"GIFTS_SHOW_NAME" => "Y",	// Показывать название
			"GIFTS_SHOW_OLD_PRICE" => "Y",	// Показывать старую цену
			"HIDE_NOT_AVAILABLE_OFFERS" => "N",	// Недоступные торговые предложения
			"IBLOCK_ID" => IBLOCK_ID__CATALOG,	// Инфоблок
			"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
			"IMAGE_RESOLUTION" => "1by1",	// Соотношение сторон изображения товара
			"LABEL_PROP" => "",
			"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",	// URL на страницу, где будет показан список связанных элементов
			"LINK_IBLOCK_ID" => "",	// ID инфоблока, элементы которого связаны с текущим элементом
			"LINK_IBLOCK_TYPE" => "",	// Тип инфоблока, элементы которого связаны с текущим элементом
			"LINK_PROPERTY_SID" => "",	// Свойство, в котором хранится связь
			"MAIN_BLOCK_PROPERTY_CODE" => array(
				0 => "VENDOR_CODE",
				1 => "BRAND",
			),
			"MESSAGE_404" => "",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
			"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
			"MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
			"MESS_COMMENTS_TAB" => "Комментарии",	// Текст вкладки "Комментарии"
			"MESS_DESCRIPTION_TAB" => "Описание",	// Текст вкладки "Описание"
			"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
			"MESS_PRICE_RANGES_TITLE" => "Цены",	// Название блока c расширенными ценами
			"MESS_PROPERTIES_TAB" => "Параметры",	// Текст вкладки "Характеристики"
			"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
			"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
			"OFFERS_LIMIT" => "0",	// Максимальное количество предложений для показа (0 - все)
			"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
			"PRICE_CODE" => array(	// Тип цены
				0 => "RETAIL_PRICE",
				1 => "WHOLESALE_PRICE",
			),
			"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
			"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
			"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
			"PRODUCT_INFO_BLOCK_ORDER" => "sku,props",	// Порядок отображения блоков информации о товаре
			"PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",	// Порядок отображения блоков покупки товара
			"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
			"PRODUCT_SUBSCRIPTION" => "Y",	// Разрешить оповещения для отсутствующих товаров
			"SECTION_CODE" => "",	// Код раздела
			"SECTION_CODE_PATH" => "",	// Путь из символьных кодов раздела
			"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
			"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
			"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
			"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
			"SEF_RULE" => "",	// Правило для обработки
			"SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
			"SET_CANONICAL_URL" => "N",	// Устанавливать канонический URL
			"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
			"SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
			"SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
			"SET_STATUS_404" => "Y",	// Устанавливать статус 404
			"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
			"SET_VIEWED_IN_COMPONENT" => "N",	// Включить сохранение информации о просмотре товара для старых шаблонов
			"SHOW_404" => "Y",	// Показ специальной страницы
			"SHOW_CLOSE_POPUP" => "Y",	// Показывать кнопку продолжения покупок во всплывающих окнах
			"SHOW_DEACTIVATED" => "N",	// Показывать деактивированные товары
			"SHOW_DISCOUNT_PERCENT" => "Y",	// Показывать процент скидки
			"SHOW_MAX_QUANTITY" => "N",	// Показывать остаток товара
			"SHOW_OLD_PRICE" => "Y",	// Показывать старую цену
			"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
			"SHOW_SLIDER" => "Y",	// Показывать слайдер для товаров
			"SLIDER_INTERVAL" => "5000",
			"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа элемента
			"TEMPLATE_THEME" => "blue",	// Цветовая тема
			"USE_COMMENTS" => "Y",	// Включить отзывы о товаре
			"USE_ELEMENT_COUNTER" => "Y",	// Использовать счетчик просмотров
			"USE_ENHANCED_ECOMMERCE" => "N",	// Включить отправку данных в электронную торговлю
			"USE_GIFTS_DETAIL" => "Y",	// Показывать блок "Подарки" в детальном просмотре
			"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",	// Показывать блок "Товары к подарку" в детальном просмотре
			"USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
			"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
			"USE_PRODUCT_QUANTITY" => "Y",	// Разрешить указание количества товара
			"USE_RATIO_IN_RANGES" => "N",	// Учитывать коэффициенты для диапазонов цен
			"USE_VOTE_RATING" => "Y",	// Включить рейтинг товара
			"VK_API_ID" => "API_ID",
			"VK_USE" => "N",	// Использовать Вконтакте
			"VOTE_DISPLAY_AS_RATING" => "rating",	// В качестве рейтинга показывать
		),
			false
		);
		?>

		<?
		$APPLICATION->IncludeComponent("bitrix:catalog.products.viewed", "detail_viewed", Array(
			"ACTION_VARIABLE" => "action_cpv",	// Название переменной, в которой передается действие
			"ADDITIONAL_PICT_PROP_1" => "-",
			"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
			"ADD_TO_BASKET_ACTION" => "ADD",	// Показывать кнопку добавления в корзину или покупки
			"BASKET_URL" => PATH_TO_BASKET,	// URL, ведущий на страницу с корзиной покупателя
			"CACHE_GROUPS" => "Y",	// Учитывать права доступа
			"CACHE_TIME" => "3600",	// Время кеширования (сек.)
			"CACHE_TYPE" => "A",	// Тип кеширования
			"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
			"DEPTH" => "2",	// Максимальная отображаемая глубина разделов
			"DISCOUNT_PERCENT_POSITION" => "top-left",	// Расположение процента скидки
			"DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
			"ENLARGE_PRODUCT" => "STRICT",	// Выделять товары в списке
			"HIDE_NOT_AVAILABLE" => "N",	// Недоступные товары
			"HIDE_NOT_AVAILABLE_OFFERS" => "N",	// Недоступные торговые предложения
			"IBLOCK_ID" => IBLOCK_ID__CATALOG,	// Инфоблок
			"IBLOCK_MODE" => "single",	// Показывать товары из
			"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
			"LABEL_PROP_1" => "",
			"LABEL_PROP_POSITION" => "top-left",	// Расположение меток товара
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
			"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
			"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
			"MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
			"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
			"PAGE_ELEMENT_COUNT" => "10",	// Количество элементов на странице
			"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
			"PRICE_CODE" => array(	// Тип цены
				0 => "RETAIL_PRICE",
				1 => "WHOLESALE_PRICE",
			),
			"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
			"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",	// Порядок отображения блоков товара
			"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
			"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
			"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false}]",	// Вариант отображения товаров
			"PRODUCT_SUBSCRIPTION" => "N",	// Разрешить оповещения для отсутствующих товаров
			"SECTION_CODE" => "",	// Код раздела
			"SECTION_ELEMENT_CODE" => "",	// Символьный код элемента, для которого будет выбран раздел
			"SECTION_ELEMENT_ID" => $GLOBALS["CATALOG_CURRENT_ELEMENT_ID"],	// ID элемента, для которого будет выбран раздел
			"SECTION_ID" => $GLOBALS["CATALOG_CURRENT_SECTION_ID"],	// ID раздела
			"SHOW_CLOSE_POPUP" => "Y",	// Показывать кнопку продолжения покупок во всплывающих окнах
			"SHOW_DISCOUNT_PERCENT" => "Y",	// Показывать процент скидки
			"SHOW_FROM_SECTION" => "N",	// Показывать товары из раздела
			"SHOW_MAX_QUANTITY" => "N",	// Показывать остаток товара
			"SHOW_OLD_PRICE" => "Y",	// Показывать старую цену
			"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
			"SHOW_SLIDER" => "N",	// Показывать слайдер для товаров
			"SLIDER_INTERVAL" => "3000",
			"SLIDER_PROGRESS" => "N",
			"TEMPLATE_THEME" => "blue",	// Цветовая тема
			"USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
			"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
			"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
		),
			false
		);
		?>
	</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>