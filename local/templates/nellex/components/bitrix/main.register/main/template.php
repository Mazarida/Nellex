<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arParams
 * @var array $arResult
 * @param CBitrixComponentTemplate $this
 */

use Bitrix\Main\Localization\Loc;

//PR($arResult, true);
?>

<div class="bx-auth-reg">
	<?if($USER->IsAuthorized()):?>
		<p><?=Loc::getMessage("MAIN_REGISTER_AUTH")?></p>
	<?else:?>
		<?if (count($arResult["ERRORS"]) > 0):?>
			<?
			foreach ($arResult["ERRORS"] as $key => $error)
				if (intval($key) == 0 && $key !== 0)
					$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".Loc::getMessage("REGISTER_FIELD_".$key)."&quot;", $error);

			ShowError(implode("<br />", $arResult["ERRORS"]));
			?>
		<?elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
			<p><?=Loc::getMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
		<?endif?>

		<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data" class="reg__form">
			<?if($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?endif;?>

			<div class="had__reg"><?=Loc::getMessage('AUTH_FIELDS_TITLE')?></div>
			<div class="flex-row col__inp-reg-f">
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['LOGIN'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[LOGIN]" value="<?=$arResult["VALUES"]["LOGIN"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_LOGIN')?>" class="login__input-f">
				</label>

				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['PASSWORD'] == "Y") echo 'valide-req';?>">
					<input type="password" name="REGISTER[PASSWORD]" value="<?=$arResult["VALUES"]["PASSWORD"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_PASSWORD')?>" class="login__input-f" autocomplete="off">
					<?if($arResult["SECURE_AUTH"]):?>
						<span class="bx-auth-secure" id="bx_auth_secure" title="<?=Loc::getMessage("AUTH_SECURE_NOTE")?>" style="display:none">
						<div class="bx-auth-secure-icon"></div>
						</span>
						<noscript>
							<span class="bx-auth-secure" title="<?=Loc::getMessage("AUTH_NONSECURE_NOTE")?>">
								<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
							</span>
						</noscript>
						<script type="text/javascript">
							document.getElementById('bx_auth_secure').style.display = 'inline-block';
						</script>
					<?endif?>
				</label>

				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['CONFIRM_PASSWORD'] == "Y") echo 'valide-req';?>">
					<input type="password" name="REGISTER[CONFIRM_PASSWORD]" value="<?=$arResult["VALUES"]["CONFIRM_PASSWORD"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_CONFIRM_PASSWORD')?>" class="login__input-f" autocomplete="off">
				</label>
			</div>

			<div class="had__reg"><?=Loc::getMessage('CONTACTS_FIELDS_TITLE')?></div>
			<div class="flex-row col__inp-reg-f">
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['NAME'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[NAME]" value="<?=$arResult["VALUES"]["NAME"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_NAME')?>" class="login__input-f">
				</label>
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['LAST_NAME'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[LAST_NAME]" value="<?=$arResult["VALUES"]["LAST_NAME"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_LAST_NAME')?>" class="login__input-f">
				</label>
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['SECOND_NAME'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[SECOND_NAME]" value="<?=$arResult["VALUES"]["SECOND_NAME"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_SECOND_NAME')?>" class="login__input-f">
				</label>

				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['UF_INN'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[UF_INN]" value="<?=$arResult["VALUES"]["UF_INN"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_UF_INN')?>" class="login__input-f">
				</label>
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['EMAIL'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[EMAIL]" value="<?=$arResult["VALUES"]["EMAIL"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_EMAIL')?>" class="login__input-f">
				</label>
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['PERSONAL_PHONE'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[PERSONAL_PHONE]" value="<?=$arResult["VALUES"]["PERSONAL_PHONE"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_PERSONAL_PHONE')?>" class="login__input-f">
				</label>
			</div>

			<div class="had__reg"><?=Loc::getMessage('ADDRESS_FIELDS_TITLE')?></div>
			<div class="flex-row col__inp-reg-f">
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['PERSONAL_CITY'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[PERSONAL_CITY]" value="<?=$arResult["VALUES"]["PERSONAL_CITY"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_PERSONAL_CITY')?>" class="login__input-f">
				</label>
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['PERSONAL_STREET'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[PERSONAL_STREET]" value="<?=$arResult["VALUES"]["PERSONAL_STREET"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_PERSONAL_STREET')?>" class="login__input-f">
				</label>
				<?/*<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['UF_STREET'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[UF_STREET]" value="<?=$arResult["VALUES"]["UF_STREET"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_UF_STREET')?>" class="login__input-f">
				</label>*/?>
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['PERSONAL_ZIP'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[PERSONAL_ZIP]" value="<?=$arResult["VALUES"]["PERSONAL_ZIP"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_PERSONAL_ZIP')?>" class="login__input-f">
				</label>

				<?/*<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['UF_HOUSE'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[UF_HOUSE]" value="<?=$arResult["VALUES"]["UF_HOUSE"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_UF_HOUSE')?>" class="login__input-f">
				</label>
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['UF_CORPSE'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[UF_CORPSE]" value="<?=$arResult["VALUES"]["UF_CORPSE"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_UF_CORPSE')?>" class="login__input-f">
				</label>
				<label class="form__regd-labl-c3 <?if ($arResult["REQUIRED_FIELDS_FLAGS"]['UF_APARTMENTS'] == "Y") echo 'valide-req';?>">
					<input type="text" name="REGISTER[UF_APARTMENTS]" value="<?=$arResult["VALUES"]["UF_APARTMENTS"]?>" placeholder="<?=Loc::getMessage('REGISTER_FIELD_UF_APARTMENTS')?>" class="login__input-f">
				</label>*/?>
			</div>

			<?// ********************* User properties ***************************************************?>
			<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
				<tr><td colspan="2"><?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : Loc::getMessage("USER_TYPE_EDIT_TAB")?></td></tr>
				<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
					<tr><td><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="starrequired">*</span><?endif;?></td><td>
							<?$APPLICATION->IncludeComponent(
								"bitrix:system.field.edit",
								$arUserField["USER_TYPE"]["USER_TYPE_ID"],
								array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
				<?endforeach;?>
			<?endif;?>
			<?// ******************** /User properties ***************************************************?>

			<?if ($arResult["USE_CAPTCHA"] == "Y"):?>
				<tr>
					<td colspan="2"><b><?=Loc::getMessage("REGISTER_CAPTCHA_TITLE")?></b></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
					</td>
				</tr>
				<tr>
					<td><?=Loc::getMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span></td>
					<td><input type="text" name="captcha_word" maxlength="50" value="" /></td>
				</tr>
			<?endif;?>

			<div class="fild-infoz f-reg"><?=Loc::getMessage("AUTH_REQ")?></div>
			<button class="login__submit" type="submit" name="register_submit_button" value="<?=Loc::getMessage("AUTH_REGISTER")?>"><?=Loc::getMessage("AUTH_REGISTER")?></button>
		</form>
	<?endif?>
</div>