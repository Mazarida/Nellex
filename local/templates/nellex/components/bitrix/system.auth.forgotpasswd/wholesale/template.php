<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;

ShowMessage($arParams["~AUTH_RESULT"]);
?>

<form id="forget" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="lost_reset_password">
	<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?endif;?>
	
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">

	<p><?=Loc::getMessage("AUTH_FORGOT_PASSWORD_1")?></p>

	<?/*<div style="margin-bottom:15px;"><strong><?=Loc::getMessage("AUTH_GET_CHECK_STRING")?></strong></div>*/?>

	<input class="login__input-f" type="text" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" placeholder="<?=Loc::getMessage("AUTH_LOGIN")?>">

	<p><?=Loc::getMessage("AUTH_OR")?></p>

	<input class="login__input-f" type="text" name="USER_EMAIL" value="" placeholder="<?=Loc::getMessage("AUTH_EMAIL")?>">

	<?/*if ($arResult["USE_CAPTCHA"]):?>
		<p class="form-row">
			<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
		</p>

		<p class="form-row">
			<?=Loc::getMessage("system_auth_captcha")?>
			<input type="text" name="captcha_word" maxlength="50" value="" />
		</p>
	<?endif;*/?>

	<button class="login__submit" type="submit" name="send_account_info" value="<?=Loc::getMessage("AUTH_SEND")?>"><?=Loc::getMessage("AUTH_SEND")?></button>

	<a href="<?=PATH_TO_AUTH_WHOLESALE?>" class="forgot-pass"><?=Loc::getMessage("REMEMBER_PASSWORD_LINK_TITLE")?></a>
</form>

<script type="text/javascript">
	document.bform.USER_LOGIN.focus();
</script>
