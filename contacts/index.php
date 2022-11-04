<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Контакты");
?>

    <div class="content__wrapper-contacts">
        <div class="flex-row cnts__flexirow">
            <div class="conts__col1">
                <div class="cnts__headr">
                    <?$APPLICATION->IncludeFile(SITE_DIR."/include/contacts/contact_1_title.php", Array(), Array("MODE" => "text"));?>
                </div>
                <div class="cnts__addr">
                    <?$APPLICATION->IncludeFile(SITE_DIR."/include/contacts/contact_1_address.php", Array(), Array("MODE" => "text"));?>
                </div>
                <div class="cnts__wktime">
                    Режим работы: <br>
                    <?$APPLICATION->IncludeFile(SITE_DIR."/include/contacts/contact_1_working_time.php", Array(), Array("MODE" => "text"));?>
                </div>
                <a href="javascript:void(0);" data-id="moscow" class="cnts__watchmap" onclick="changeYandexMap($(this).data('id'));">Посмотреть на карте</a>
            </div>
            <?php /*<div class="conts__col2">
                <div class="cnts__headr">
                    <?$APPLICATION->IncludeFile(SITE_DIR."/include/contacts/contact_2_title.php", Array(), Array("MODE" => "text"));?>
                </div>
                <div class="cnts__addr">
                    <?$APPLICATION->IncludeFile(SITE_DIR."/include/contacts/contact_2_address.php", Array(), Array("MODE" => "text"));?>
                </div>
                <div class="cnts__wktime">
                    Режим работы: <br>
                    <?$APPLICATION->IncludeFile(SITE_DIR."/include/contacts/contact_2_working_time.php", Array(), Array("MODE" => "text"));?>
                </div>
                <a href="javascript:void(0);" data-id="cherkessk" class="cnts__watchmap" onclick="changeYandexMap($(this).data('id'));">Посмотреть на карте</a>
            </div>*/ ?>
            <div class="conts__col3">
                <div class="cnts__headr">Контактные телефоны</div>
                <div class="cnts__phonds">
                    <?$APPLICATION->IncludeFile(SITE_DIR."/include/contacts/contacts_phone.php", Array(), Array("MODE" => "html"));?>
                </div>
                <a href="#" class="cnts__callback">Заказать звонок</a>
                <div class="cnts__headr head-eml">E-mail</div>
                <div class="cnts__emal">
                    E-mail: <?$APPLICATION->IncludeFile(SITE_DIR."/include/contacts/contacts_email.php", Array(), Array("MODE" => "html"));?>
                </div>
            </div>
        </div>
        <div id="moscow" class="cnts__mapd">
            <?// картинка баллуна: https://dev.1c-bitrix.ru/support/forum/forum6/topic59790/
            $APPLICATION->IncludeComponent("bitrix:map.yandex.view", "contacts", Array(
                "CONTROLS" => array(    // Элементы управления
                    0 => "ZOOM",
                    1 => "MINIMAP",
                    2 => "TYPECONTROL",
                    3 => "SCALELINE",
                ),
                "INIT_MAP_TYPE" => "MAP",    // Стартовый тип карты
                "MAP_DATA" => serialize(array(
                    'yandex_lat' => 55.758929,
                    'yandex_lon' => 37.664464,
                    'yandex_scale' => 17,
                    'PLACEMARKS' => array (
                        array(
                            'TEXT' => "NELLEX",
                            'LAT' => 55.758929,
                            'LON' => 37.664464,
                        ),
                    ),
                )),    // Данные, выводимые на карте
                "MAP_HEIGHT" => "445",    // Высота карты
                "MAP_ID" => "tab-map",    // Идентификатор карты
                "MAP_WIDTH" => "100%",    // Ширина карты
                "OPTIONS" => array(    // Настройки
                    0 => "ENABLE_DBLCLICK_ZOOM",
                    1 => "ENABLE_DRAGGING",
                    //2 => "ENABLE_SCROLL_ZOOM",
                ),
                "COMPONENT_TEMPLATE" => ".default"
            ),
                false
            );
            ?>
        </div>
        <div id="cherkessk" class="cnts__mapd" style="display: none;">
            <?// картинка баллуна: https://dev.1c-bitrix.ru/support/forum/forum6/topic59790/
            $APPLICATION->IncludeComponent("bitrix:map.yandex.view", "contacts", Array(
                "CONTROLS" => array(    // Элементы управления
                    0 => "ZOOM",
                    1 => "MINIMAP",
                    2 => "TYPECONTROL",
                    3 => "SCALELINE",
                ),
                "INIT_MAP_TYPE" => "MAP",    // Стартовый тип карты
                "MAP_DATA" => serialize(array(
                    'yandex_lat' => 44.209878,
                    'yandex_lon' => 42.043814,
                    'yandex_scale' => 17,
                    'PLACEMARKS' => array (
                        array(
                            'TEXT' => "NELLEX",
                            'LAT' => 44.209878,
                            'LON' => 42.043814,
                        ),
                    ),
                )),    // Данные, выводимые на карте
                "MAP_HEIGHT" => "445",    // Высота карты
                "MAP_ID" => "tab-map",    // Идентификатор карты
                "MAP_WIDTH" => "100%",    // Ширина карты
                "OPTIONS" => array(    // Настройки
                    0 => "ENABLE_DBLCLICK_ZOOM",
                    1 => "ENABLE_DRAGGING",
                    //2 => "ENABLE_SCROLL_ZOOM",
                ),
                "COMPONENT_TEMPLATE" => ".default"
            ),
                false
            );
            ?>
        </div>
    </div>

<script>
    function changeYandexMap(id) {
        $('.cnts__mapd').hide();
        $('#' + id).show();
    }
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>