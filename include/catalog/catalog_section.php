<?
/**
 * @global CMain $APPLICATION
 */

$APPLICATION->IncludeComponent("bitrix:catalog.section", "main", Array(
    "ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
    "ADD_PICT_PROP" => "MORE_PHOTO",
    "ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
    "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
    "ADD_TO_BASKET_ACTION" => "ADD",	// Показывать кнопку добавления в корзину или покупки
    "AJAX_MODE" => "N",	// Включить режим AJAX
    "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
    "AJAX_OPTION_HISTORY" => "Y",	// Включить эмуляцию навигации браузера
    "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
    "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
    "BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
    "BASKET_URL" => PATH_TO_BASKET,	// URL, ведущий на страницу с корзиной покупателя
    "BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
    "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
    "CACHE_GROUPS" => "Y",	// Учитывать права доступа
    "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
    "CACHE_TYPE" => "A",	// Тип кеширования
    "COMPATIBLE_MODE" => "Y",	// Включить режим совместимости
    "CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
    "CUSTOM_FILTER" => "",
    "DETAIL_URL" => "/catalog/#ELEMENT_CODE#/",	// URL, ведущий на страницу с содержимым элемента раздела
    "DISABLE_INIT_JS_IN_COMPONENT" => "N",	// Не подключать js-библиотеки в компоненте
    "DISCOUNT_PERCENT_POSITION" => "bottom-right",	// Расположение процента скидки
    "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
    "DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
    "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
    "ELEMENT_SORT_FIELD" => "sort",	// По какому полю сортируем элементы
    "ELEMENT_SORT_FIELD2" => "name",	// Поле для второй сортировки элементов
    "ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
    "ELEMENT_SORT_ORDER2" => "asc",	// Порядок второй сортировки элементов
    "ENLARGE_PRODUCT" => "STRICT",	// Выделять товары в списке
    "FILE_404" => "",	// Страница для показа (по умолчанию /404.php)
    "FILTER_NAME" => "arrFilter",	// Имя массива со значениями фильтра для фильтрации элементов
    "HIDE_NOT_AVAILABLE" => "N",	// Недоступные товары
    "HIDE_NOT_AVAILABLE_OFFERS" => "N",	// Недоступные торговые предложения
    "IBLOCK_ID" => IBLOCK_ID__CATALOG,	// Инфоблок
    "IBLOCK_TYPE" => "catalog",	// Тип инфоблока
    "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
    "LABEL_PROP" => "",
    "LAZY_LOAD" => "N",	// Показать кнопку ленивой загрузки Lazy Load
    "LINE_ELEMENT_COUNT" => "3",	// Количество элементов выводимых в одной строке таблицы
    "LOAD_ON_SCROLL" => "N",	// Подгружать товары при прокрутке до конца
    "MESSAGE_404" => "",
    "MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
    "MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
    "MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
    "MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
    "MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
    "META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
    "META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
    "OFFERS_LIMIT" => "5",	// Максимальное количество предложений для показа (0 - все)
    "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
    "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
    "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
    "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
    "PAGER_TEMPLATE" => "modern",	// Шаблон постраничной навигации
    "PAGER_TITLE" => "Товары",	// Название категорий
    "PAGE_ELEMENT_COUNT" => "8",	// Количество элементов на странице
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
    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",	// Вариант отображения товаров
    "PRODUCT_SUBSCRIPTION" => "Y",	// Разрешить оповещения для отсутствующих товаров
    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],	// Параметр ID продукта (для товарных рекомендаций)
    "RCM_TYPE" => "personal",	// Тип рекомендации
    "SECTION_CODE" => "",	// Код раздела
    "SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
    "SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
    "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
    "SECTION_USER_FIELDS" => array(	// Свойства раздела
        0 => "",
        1 => "",
    ),
    "SEF_MODE" => "N",	// Включить поддержку ЧПУ
    "SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
    "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
    "SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
    "SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
    "SET_STATUS_404" => "Y",	// Устанавливать статус 404
    "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
    "SHOW_404" => "Y",	// Показ специальной страницы
    "SHOW_ALL_WO_SECTION" => "N",	// Показывать все элементы, если не указан раздел
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
    "USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
    "USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
    "USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
),
    false
);