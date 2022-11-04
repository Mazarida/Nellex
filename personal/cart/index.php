<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$APPLICATION->SetTitle("Корзина");

global $assets;
$assets->addCss('/personal/cart/style.css');

// Количество товаров в корзине
$items_cnt = CSaleBasket::GetList(array(),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL"
    ),
    array()
);
?>

    <h1 class="page-name"><?$APPLICATION->ShowTitle(false);?></h1>
    <div class="content__wrapper-cart">
        <div id="big_basket">
            <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "EDIT_TEMPLATE" => "",
                    "PATH" => SITE_DIR."include/basket/basket.php"
                ),
                false,
                Array(
                    'HIDE_ICONS' => 'Y',
                    'ACTIVE_COMPONENT' => ''
                )
            );?>
        </div>

        <?if($items_cnt || $_REQUEST['ORDER_ID']):?>
            <?$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "main", Array(
                "ACTION_VARIABLE" => "soa-action",	// Название переменной, в которой передается действие
                "ADDITIONAL_PICT_PROP_1" => "-",	// Дополнительная картинка [Каталог]
                "ALLOW_APPEND_ORDER" => "Y",	// Разрешить оформлять заказ на существующего пользователя
                "ALLOW_AUTO_REGISTER" => "Y",	// Оформлять заказ с автоматической регистрацией пользователя
                "ALLOW_NEW_PROFILE" => "N",	// Разрешить множество профилей покупателей
                "ALLOW_USER_PROFILES" => "N",	// Разрешить использование профилей покупателей
                "BASKET_IMAGES_SCALING" => "adaptive",	// Режим отображения изображений товаров
                "BASKET_POSITION" => "after",	// Расположение списка товаров
                "COMPATIBLE_MODE" => "Y",	// Режим совместимости для предыдущего шаблона
                "DELIVERIES_PER_PAGE" => "9",	// Количество доставок на странице
                "DELIVERY_FADE_EXTRA_SERVICES" => "N",	// Дополнительные услуги, которые будут показаны в пройденном (свернутом) блоке
                "DELIVERY_NO_AJAX" => "N",	// Когда рассчитывать доставки с внешними системами расчета
                "DELIVERY_NO_SESSION" => "Y",	// Проверять сессию при оформлении заказа
                "DELIVERY_TO_PAYSYSTEM" => "d2p",	// Последовательность оформления
                "DISABLE_BASKET_REDIRECT" => "N",	// Оставаться на странице оформления заказа, если список товаров пуст
                "EMPTY_BASKET_HINT_PATH" => PATH_TO_CATALOG,	// Путь к странице для продолжения покупок
                "HIDE_ORDER_DESCRIPTION" => "Y",	// Скрыть поле комментариев к заказу
                "MESS_ADDITIONAL_PROPS" => "Дополнительные свойства",	// Кнопка дополнительных свойств товара
                "MESS_AUTH_BLOCK_NAME" => "Авторизация",	// Название блока авторизации
                "MESS_AUTH_REFERENCE_1" => "Символом \"звездочка\" (*) отмечены обязательные для заполнения поля.",	// Справочная информация №1 блока "Авторизация"
                "MESS_AUTH_REFERENCE_2" => "После регистрации вы получите информационное письмо.",	// Справочная информация №2 блока "Авторизация"
                "MESS_AUTH_REFERENCE_3" => "Личные сведения, полученные в распоряжение интернет-магазина при регистрации или каким-либо иным образом, не будут без разрешения пользователей передаваться третьим организациям и лицам за исключением ситуаций, когда этого требует закон или судебное решение.",	// Справочная информация №3 блока "Авторизация"
                "MESS_BACK" => "Назад",	// Кнопка возврата к предыдущему блоку
                "MESS_BASKET_BLOCK_NAME" => "Товары в заказе",	// Название блока списка товаров
                "MESS_BUYER_BLOCK_NAME" => "Контакты",	// Название блока свойств заказа
                "MESS_COUPON" => "Купон",	// Заголовок для примененных купонов
                "MESS_DELIVERY_BLOCK_NAME" => "Доставка",	// Название блока доставки
                "MESS_DELIVERY_CALC_ERROR_TEXT" => "Вы можете продолжить оформление заказа, а чуть позже менеджер магазина свяжется с вами и уточнит информацию по доставке.",	// Текст ошибки расчета доставки
                "MESS_DELIVERY_CALC_ERROR_TITLE" => "Не удалось рассчитать стоимость доставки.",	// Заголовок ошибки расчета доставки
                "MESS_ECONOMY" => "Экономия",	// Текст для "Экономия"
                "MESS_EDIT" => "изменить",	// Кнопка редактирования блока
                "MESS_FAIL_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически. Обратите внимание на развернутый блок с информацией о заказе. Здесь вы можете внести необходимые изменения или оставить как есть и нажать кнопку \"#ORDER_BUTTON#\".",	// Текст уведомления о неудачной загрузке данных заказа
                "MESS_FURTHER" => "Далее",	// Кнопка перехода к следующему блоку
                "MESS_INNER_PS_BALANCE" => "На вашем пользовательском счете:",	// Информация о балансе внутреннего счета
                "MESS_NAV_BACK" => "Назад",	// Кнопка перехода к предыдущей странице
                "MESS_NAV_FORWARD" => "Вперед",	// Кнопка перехода к следующей странице
                "MESS_NEAREST_PICKUP_LIST" => "Ближайшие пункты:",	// Заголовок ближайших пунктов самовывоза
                "MESS_ORDER" => "Оформить заказ",	// Кнопка оформления заказа
                "MESS_ORDER_DESC" => "Комментарии к заказу:",	// Заголовок комментариев к заказу
                "MESS_PAYMENT_BLOCK_NAME" => "Оплата",	// Название блока оплаты
                "MESS_PAY_SYSTEM_PAYABLE_ERROR" => "Вы сможете оплатить заказ после того, как менеджер проверит наличие полного комплекта товаров на складе. Сразу после проверки вы получите письмо с инструкциями по оплате. Оплатить заказ можно будет в персональном разделе сайта.",	// Текст уведомления при статусе заказа, недоступном для оплаты
                "MESS_PERIOD" => "Срок доставки",	// Заголовок для срока доставки
                "MESS_PERSON_TYPE" => "Тип плательщика",	// Заголовок выбора типа плательщика
                "MESS_PICKUP_LIST" => "Пункты самовывоза:",	// Заголовок пунктов самовывоза
                "MESS_PRICE" => "Стоимость",	// Заголовок для цены
                "MESS_PRICE_FREE" => "бесплатно",	// Текст для "бесплатно"
                "MESS_REGION_BLOCK_NAME" => "Тип плательщика",	// Название блока региона доставки
                "MESS_REGION_REFERENCE" => "Выберите свой город в списке. Если вы не нашли свой город, выберите \"другое местоположение\", а город впишите в поле \"Город\"",	// Справочная информация блока "Регион"
                "MESS_REGISTRATION_REFERENCE" => "Если вы впервые на сайте, и хотите, чтобы мы вас помнили и все ваши заказы сохранялись, заполните регистрационную форму.",	// Текст для перехода к блоку регистрации
                "MESS_REG_BLOCK_NAME" => "Регистрация",	// Название блока регистрации
                "MESS_SELECT_PICKUP" => "Выбрать",	// Кнопка выбора пункта самовывоза
                "MESS_SELECT_PROFILE" => "Выберите профиль",	// Заголовок выбора профиля
                "MESS_SUCCESS_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически. Если все заполнено верно, нажмите кнопку \"#ORDER_BUTTON#\".",	// Текст уведомления о корректной загрузке данных заказа
                "MESS_USE_COUPON" => "Применить купон",	// Заголовок поля ввода купона
                "ONLY_FULL_PAY_FROM_ACCOUNT" => "N",	// Разрешить оплату с внутреннего счета только в полном объеме
                "PATH_TO_AUTH" => PATH_TO_AUTH,	// Путь к странице авторизации
                "PATH_TO_BASKET" => PATH_TO_BASKET,	// Путь к странице корзины
                "PATH_TO_PAYMENT" => PATH_TO_PAYMENT,	// Страница подключения платежной системы
                "PATH_TO_PERSONAL" => PATH_TO_PERSONAL,	// Путь к странице персонального раздела
                "PAY_FROM_ACCOUNT" => "N",	// Разрешить оплату с внутреннего счета
                "PAY_SYSTEMS_PER_PAGE" => "9",	// Количество платежных систем на странице
                "PICKUPS_PER_PAGE" => "5",	// Количество пунктов самовывоза на странице
                "PICKUP_MAP_TYPE" => "yandex",	// Тип используемых карт
                "PRODUCT_COLUMNS_HIDDEN" => "",	// Свойства товаров отображаемые в свернутом виде в списке товаров
                "PRODUCT_COLUMNS_VISIBLE" => array(	// Выбранные колонки таблицы списка товаров
                    0 => "PREVIEW_PICTURE",
                    1 => "PROPS",
                ),
                "SEND_NEW_USER_NOTIFY" => "Y",	// Отправлять пользователю письмо, что он зарегистрирован на сайте
                "SERVICES_IMAGES_SCALING" => "adaptive",	// Режим отображения вспомагательных изображений
                "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                "SHOW_BASKET_HEADERS" => "N",	// Показывать заголовки колонок списка товаров
                "SHOW_COUPONS_BASKET" => "Y",	// Показывать поле ввода купонов в блоке списка товаров
                "SHOW_COUPONS_DELIVERY" => "N",	// Показывать поле ввода купонов в блоке доставки
                "SHOW_COUPONS_PAY_SYSTEM" => "Y",	// Показывать поле ввода купонов в блоке оплаты
                "SHOW_DELIVERY_INFO_NAME" => "N",	// Отображать название в блоке информации по доставке
                "SHOW_DELIVERY_LIST_NAMES" => "Y",	// Отображать названия в списке доставок
                "SHOW_DELIVERY_PARENT_NAMES" => "Y",	// Показывать название родительской доставки
                "SHOW_MAP_IN_PROPS" => "N",	// Показывать карту в блоке свойств заказа
                "SHOW_NEAREST_PICKUP" => "N",	// Показывать ближайшие пункты самовывоза
                "SHOW_NOT_CALCULATED_DELIVERIES" => "L",	// Отображение доставок с ошибками расчета
                "SHOW_ORDER_BUTTON" => "always",	// Отображать кнопку оформления заказа (для неавторизованных пользователей)
                "SHOW_PAY_SYSTEM_INFO_NAME" => "N",	// Отображать название в блоке информации по платежной системе
                "SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",	// Отображать названия в списке платежных систем
                "SHOW_PICKUP_MAP" => "N",	// Показывать карту для доставок с самовывозом
                "SHOW_STORES_IMAGES" => "Y",	// Показывать изображения складов в окне выбора пункта выдачи
                "SHOW_TOTAL_ORDER_BUTTON" => "N",	// Отображать дополнительную кнопку оформления заказа
                "SHOW_VAT_PRICE" => "N",	// Отображать значение НДС
                "SKIP_USELESS_BLOCK" => "Y",	// Пропускать шаги, в которых один элемент для выбора
                "SPOT_LOCATION_BY_GEOIP" => "Y",	// Определять местоположение покупателя по IP-адресу
                "TEMPLATE_LOCATION" => "popup",	// Визуальный вид контрола выбора местоположений
                "TEMPLATE_THEME" => "site",	// Цветовая тема
                "USER_CONSENT" => "Y",	// Запрашивать согласие
                "USER_CONSENT_ID" => "1",	// Соглашение
                "USER_CONSENT_IS_CHECKED" => "Y",	// Галка по умолчанию проставлена
                "USER_CONSENT_IS_LOADED" => "N",	// Загружать текст сразу
                "USE_CUSTOM_ADDITIONAL_MESSAGES" => "Y",	// Заменить стандартные фразы на свои
                "USE_CUSTOM_ERROR_MESSAGES" => "Y",	// Заменить стандартные фразы на свои
                "USE_CUSTOM_MAIN_MESSAGES" => "Y",	// Заменить стандартные фразы на свои
                "USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
                "USE_PHONE_NORMALIZATION" => "Y",	// Использовать нормализацию номера телефона
                "USE_PRELOAD" => "Y",	// Автозаполнение оплаты и доставки по предыдущему заказу
                "USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
                "USE_YM_GOALS" => "N",	// Использовать цели счетчика Яндекс.Метрики
            ),
                false
            );?>
        <?else:?>
            <div class="bx-sbb-empty-cart-container">
                <div class="bx-sbb-empty-cart-image">
                    <img src="" alt="">
                </div>
                <div class="bx-sbb-empty-cart-text"><?=Loc::getMessage("SBB_EMPTY_BASKET_TITLE")?></div>
                <div class="bx-sbb-empty-cart-desc">
                    <?=Loc::getMessage(
                        'SBB_EMPTY_BASKET_HINT',
                        [
                            '#A1#' => '<a href="'.PATH_TO_CATALOG.'">',
                            '#A2#' => '</a>',
                        ]
                    )?>
                </div>
            </div>
        <?endif;?>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>