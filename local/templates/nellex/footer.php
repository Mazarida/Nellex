<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
?>

<div class="foot-section-hld">
    <div class="flex-row foot-section-r1">
        <div class="foot-section-evn">
            <?
//            $APPLICATION->IncludeComponent("bitrix:subscribe.edit", "main_page", Array(
//                "AJAX_MODE" => "N",	// Включить режим AJAX
//                "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
//                "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
//                "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
//                "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
//                "ALLOW_ANONYMOUS" => "Y",	// Разрешить анонимную подписку
//                "CACHE_TIME" => "3600",	// Время кеширования (сек.)
//                "CACHE_TYPE" => "A",	// Тип кеширования
//                "SET_TITLE" => "N",	// Устанавливать заголовок страницы
//                "SHOW_AUTH_LINKS" => "N",	// Показывать ссылки на авторизацию при анонимной подписке
//                "SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
//            ),
//                false
//            );
            $APPLICATION->IncludeComponent("bitrix:subscribe.form", "main_page", Array(
                "CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "CACHE_TYPE" => "A",	// Тип кеширования
                "PAGE" => "#SITE_DIR#personal/subscribe/",	// Страница редактирования подписки (доступен макрос #SITE_DIR#)
                "SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
                "USE_PERSONALIZATION" => "Y",	// Определять подписку текущего пользователя
            ),
                false
            );
            ?>
        </div>

        <div class="flex-row foot-section-evn">
            <? // Главное верхнее меню в шапке
            $APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", Array(
                "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                "CHILD_MENU_TYPE" => "bottom",	// Тип меню для остальных уровней
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                    0 => "",
                ),
                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                "ROOT_MENU_TYPE" => "bottom",	// Тип меню для первого уровня
                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
            ),
                false
            );
            ?>
            <div class="foots__nav">
                <?$APPLICATION->IncludeFile(SITE_DIR."/include/footer/social_links.php", Array(), Array("MODE" => "html"));?>
            </div>
        </div>
    </div>

    <div class="flex-row foot-section-r2">
        <div class="foot-section-evn">
            <a href="<?=SITE_DIR?>" class="foot__logo"></a>
        </div>
        <div class="flex-row foot-section-evn">
            <div class="flex-row foot__pmethds">
                <a href="<?=PATH_TO_CONTACTS?>" class="pmethd-logo pmethd__visa"></a>
                <a href="<?=PATH_TO_CONTACTS?>" class="pmethd-logo pmethd__mastercard"></a>
                <a href="<?=PATH_TO_CONTACTS?>" class="pmethd-logo pmethd__maestro"></a>
            </div>
            <div class="foot__copyright">
                <?$APPLICATION->IncludeFile(SITE_DIR."/include/footer/copyright.php", Array(), Array("MODE" => "text"));?>
            </div>
        </div>
    </div>
</div>

<div id="modal__add-to-cart" class="modal__add-to-cart">
    <div class="modal__add-to-cart-text"><?=Loc::getMessage('MODAL_ADD_TO_CART_MESS')?></div>
</div>

<style>
    .modal__add-to-cart {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        width: 280px;
        background: #fff;
        text-align: center;
        line-height: 1.25;
        color: #000;
        padding: 20px;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        overflow-y: auto;
        -webkit-box-shadow: inset 0 0 0 4px #000;
        box-shadow: inset 0 0 0 4px #000;
        z-index: 99999;
        white-space: nowrap;
    }
    .modal__add-to-cart-text {
        font-size: 18px;
        text-align: center;
    }
</style>

</body>
</html>