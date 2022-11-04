<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

if (!$USER->IsAuthorized()) {
    LocalRedirect(PATH_TO_AUTH);
}

$APPLICATION->SetTitle("Личный кабинет");
?>

    <h1 class="page-name"><?$APPLICATION->ShowTitle(false);?></h1>
    <div class="content__wrapper-private_office">
        <? // Верхнее меню в личном кабинете
        $APPLICATION->IncludeComponent("bitrix:menu", "personal_menu", Array(
            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
            "CHILD_MENU_TYPE" => "personal",	// Тип меню для остальных уровней
            "DELAY" => "N",	// Откладывать выполнение шаблона меню
            "MAX_LEVEL" => "1",	// Уровень вложенности меню
            "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                0 => "",
            ),
            "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "MENU_CACHE_TYPE" => "N",	// Тип кеширования
            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
            "ROOT_MENU_TYPE" => "personal",	// Тип меню для первого уровня
            "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
        ),
            false
        );
        ?>

        <?$APPLICATION->IncludeComponent("bitrix:sale.personal.section", "main", Array(
            "ACCOUNT_PAYMENT_SELL_USER_INPUT" => "Y",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "CACHE_GROUPS" => "Y",	// Учитывать права доступа
            "CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "CACHE_TYPE" => "A",	// Тип кеширования
            "CHECK_RIGHTS_PRIVATE" => "N",	// Проверять права доступа
            "COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
            "CUSTOM_PAGES" => "",	// Настройки дополнительных страниц раздела
            "CUSTOM_SELECT_PROPS" => array(
                0 => "",
            ),
            "MAIN_CHAIN_NAME" => "Личный кабинет",	// Название раздела в цепочке навигации
            "NAV_TEMPLATE" => "",
            "ORDERS_PER_PAGE" => "20",
            "ORDER_DEFAULT_SORT" => "STATUS",
            "ORDER_HIDE_USER_INFO" => array(
                0 => "0",
            ),
            "ORDER_HISTORIC_STATUSES" => array(
                0 => "F",
            ),
            "ORDER_REFRESH_PRICES" => "N",
            "ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
                0 => "0",
            ),
            "PATH_TO_BASKET" => "/personal/cart/",	// Путь к корзине
            "PATH_TO_CATALOG" => PATH_TO_CATALOG,	// Путь к каталогу
            "PATH_TO_CONTACT" => PATH_TO_CONTACTS,	// Путь к странице контактных данных
            "PATH_TO_PAYMENT" => "/personal/order/payment/",	// Путь к странице оплат
            "PROFILES_PER_PAGE" => "20",
            "SAVE_IN_SESSION" => "Y",
            "SEF_FOLDER" => "/personal/",	// Каталог ЧПУ (относительно корня сайта)
            "SEF_MODE" => "Y",	// Включить поддержку ЧПУ
            "SEF_URL_TEMPLATES" => array(
                "account" => "account/",
                "index" => "index.php",
                "history" => "history/",
                "order_cancel" => "cancel/#ID#",
                "order_detail" => "orders/#ID#",
                "orders" => "orders/",
                "private" => "private/",
                "profile" => "profiles/",
                "profile_detail" => "profiles/#ID#",
                "subscribe" => "subscribe/",
            ),
            "SEND_INFO_PRIVATE" => "N",	// Генерировать почтовое событие
            "SET_TITLE" => "N",	// Устанавливать заголовок страницы
            "SHOW_ACCOUNT_PAGE" => "N",	// Показать страницу персонального счета пользователя
            "SHOW_BASKET_PAGE" => "N",	// Вывести ссылку на корзину
            "SHOW_CONTACT_PAGE" => "N",	// Вывести ссылку на страницу контактов
            "SHOW_ORDER_PAGE" => "N",	// Показать страницу заказов пользователя
            "SHOW_PRIVATE_PAGE" => "Y",	// Показать страницу персональных данных пользователя
            "SHOW_PROFILE_PAGE" => "N",	// Показать страницу профилей пользователя
            "SHOW_SUBSCRIBE_PAGE" => "Y",	// Показать страницу подписок
            "USE_AJAX_LOCATIONS_PROFILE" => "N"
        ),
            false
        );?>
        <a href="/?logout=yes" class="conts__edit-btn personal__logout">Выйти</a>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>