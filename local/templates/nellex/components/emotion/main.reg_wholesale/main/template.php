<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use Bitrix\Main\Localization\Loc;
?>

<?
if (!empty($arResult["ERROR_MESSAGE"])) {
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
?>

<?if (strlen($arResult["OK_MESSAGE"]) > 0):?>
	<div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div>
<?endif;?>

<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
	<?=bitrix_sessid_post()?>

	<div class="had__reg"><?=Loc::getMessage("TITLE_CONTACTS")?></div>

	<div class="flex-row col__inp-reg-f">
		<label class="valide-req form__regd-labl-c3">
			<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>" placeholder="<?=Loc::getMessage("MFT_NAME")?>" class="login__input-f">
		</label>

		<label class="valide-req form__regd-labl-c3">
			<input type="text" name="user_surname" value="<?=$arResult["AUTHOR_SURNAME"]?>" placeholder="<?=Loc::getMessage("MFT_SURNAME")?>" class="login__input-f">
		</label>

		<label class="valide-req form__regd-labl-c3">
			<input type="text" name="user_patronymic" value="<?=$arResult["AUTHOR_PATRONYMIC"]?>" placeholder="<?=Loc::getMessage("MFT_PATRONYMIC")?>" class="login__input-f">
		</label>

		<label class="valide-req form__regd-labl-c3">
			<input type="text" name="user_city" value="<?=$arResult["AUTHOR_CITY"]?>" placeholder="<?=Loc::getMessage("MFT_CITY")?>" class="login__input-f">
		</label>

		<label class="valide-req form__regd-labl-c3">
			<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" placeholder="<?=Loc::getMessage("MFT_EMAIL")?>" class="login__input-f">
		</label>

		<label class="valide-req form__regd-labl-c3">
			<input type="text" name="user_phone" value="<?=$arResult["AUTHOR_PHONE"]?>" placeholder="<?=Loc::getMessage("MFT_PHONE")?>" class="login__input-f">
		</label>
	</div>

	<?/*<div class="form_element">
		<label>
			<span><?=Loc::getMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?></span>
			<textarea name="MESSAGE" rows="5" cols="40" class="textinputs"><?=$arResult["MESSAGE"]?></textarea>
		</label>
	</div>*/?>

	<?if ($arParams["USE_CAPTCHA"] == "Y"):?>
		<div class="mf-captcha">
			<div class="mf-text"><?=Loc::getMessage("MFT_CAPTCHA")?></div>
			<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
			<div class="mf-text"><?=Loc::getMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
			<input type="text" name="captcha_word" size="30" maxlength="50" value="">
		</div>
	<?endif;?>

	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">

	<div class="fild-infoz f-reg"><?=Loc::getMessage("MFT_INFO")?></div>
	<button class="login__submit" type="submit" name="submit" value="<?=Loc::getMessage("MFT_SUBMIT")?>"><?=Loc::getMessage("MFT_SUBMIT")?></button>
</form>