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

<div class="in" style="padding:15px;">
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

		<div class="form_element">
			<label class="required">
				<span><?=Loc::getMessage("MFT_NAME")?><?if (empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif;?></span>
				<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>" class="textinputs" />
			</label>
		</div>

		<div class="form_element">
			<label class="required">
				<span><?=Loc::getMessage("MFT_PHONE")?><?if (empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif;?></span>
				<input type="text" name="user_phone" value="<?=$arResult["AUTHOR_PHONE"]?>" class="textinputs" />
			</label>
		</div>

		<div class="form_element">
			<label class="required">
				<span><?=Loc::getMessage("MFT_EMAIL")?><?if (empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif;?></span>
				<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" class="textinputs" />
			</label>
		</div>

		<div class="form_element">
			<label>
				<span><?=Loc::getMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?></span>
				<textarea name="MESSAGE" rows="5" cols="40" class="textinputs"><?=$arResult["MESSAGE"]?></textarea>
			</label>
		</div>

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
		<div class="form_element">
			<input type="submit" name="submit" value="<?=Loc::getMessage("MFT_SUBMIT")?>" class="button" />
		</div>
	</form>
</div>