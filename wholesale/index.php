<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Оптом");
?>

    <div class="content__wrapper-optom">
        <h1 class="page-name"><?$APPLICATION->ShowTitle(false);?></h1>
        <div class="flex-row login-reg">
            <div class="col__login">
                <div class="loginreg__head">Вход</div>
                <?
                $APPLICATION->IncludeComponent("bitrix:system.auth.form", "wholesale", Array(
                    "FORGOT_PASSWORD_URL" => PATH_TO_RECOVERY_PASSWORD_WHOLESALE,	// Страница забытого пароля
                    "PROFILE_URL" => PATH_TO_PERSONAL,	// Страница профиля
                    "REGISTER_URL" => "",	// Страница регистрации
                    "SHOW_ERRORS" => "Y",	// Показывать ошибки
                ),
                    false
                );
                ?>
            </div>

            <div class="col__reg">
                <div class="loginreg__head">Заявка на регистрацию</div>
                <?
                $APPLICATION->IncludeComponent("emotion:main.reg_wholesale", "main", Array(
                    "AJAX_MODE" => "N",  // режим AJAX
                    "AJAX_OPTION_SHADOW" => "N", // затемнять область
                    "AJAX_OPTION_JUMP" => "N", // скроллить страницу до компонента
                    "AJAX_OPTION_STYLE" => "Y", // подключать стили
                    "AJAX_OPTION_HISTORY" => "N",
                    "EMAIL_TO" => "",	// E-mail, на который будет отправлено письмо
                    "EVENT_MESSAGE_ID" => array(86),	// Почтовые шаблоны для отправки письма
                    "OK_TEXT" => "Спасибо, ваше сообщение принято.",	// Сообщение, выводимое пользователю после отправки
                    "REQUIRED_FIELDS" => array(	// Обязательные поля для заполнения
                        0 => "NAME",
                        1 => "SURNAME",
                        2 => "PATRONYMIC",
                        3 => "CITY",
                        4 => "PHONE",
                        5 => "EMAIL",
                    ),
                    "USE_CAPTCHA" => "N",	// Использовать защиту от автоматических сообщений (CAPTCHA) для неавторизованных пользователей
                ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
                ?>
            </div>
        </div>
    </div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>