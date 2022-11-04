<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Восстановление пароля");

//if ($USER->IsAuthorized()) {
//    LocalRedirect(PATH_TO_PERSONAL);
//}
?>

    <div class="content__wrapper-reg">
        <div class="flex-row login-reg">
            <div class="col__login">
                <div class="loginreg__head">Восстановление пароля</div>
                <?
                $APPLICATION->IncludeComponent("bitrix:system.auth.form", "errors", Array(
                        "REGISTER_URL" => "",
                        "FORGOT_PASSWORD_URL" => "",
                        "PROFILE_URL" => "",
                        "SHOW_ERRORS" => "Y"
                    )
                );
                ?>
                <?
                $APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd", "wholesale", Array(
                        "SHOW_ERRORS" => "Y",
                    )
                );
                ?>
            </div>
        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>