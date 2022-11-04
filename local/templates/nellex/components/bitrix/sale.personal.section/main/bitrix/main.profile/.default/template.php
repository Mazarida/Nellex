<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;

$arFIO[0] = $arResult['arUser']['LAST_NAME'];
$arFIO[1] = $arResult['arUser']['NAME'];
$arFIO[2] = $arResult['arUser']['SECOND_NAME'];

ShowError($arResult["strProfileError"]);

if ($arResult['DATA_SAVED'] == 'Y') {
	ShowNote(Loc::getMessage('PROFILE_DATA_SAVED'));
}
?>

<div class="flex-row priv__of-cols">
	<div class="col__priv-r">
		<div class="p_of"><?=Loc::getMessage('CONTACTS_SUBSECTION_TITLE')?></div>
		<div class="conts__sect">
			<div class="lk__nmae"><?=implode(' ', $arFIO);?></div>
			<div class="lk__email"><?=Loc::getMessage('EMAIL').' '.$arResult['arUser']['EMAIL']?></div>
			<div class="lk__tel"><?=Loc::getMessage('PERSONAL_PHONE').' '.$arResult['arUser']['PERSONAL_PHONE']?></div>
			<div class="lk__inn"><?=Loc::getMessage('UF_INN').' '.$arResult['arUser']['UF_INN']?></div>
		</div>
		<div class="conts__edit-btn" onclick="editPersonalData(this);"><?=Loc::getMessage('EDIT_BUTTON_TITLE')?></div>
	</div>
	<div class="col__priv-r2">
		<div class="p_of"><?=Loc::getMessage('DELIVERY_ADDRESS_SUBSECTION_TITLE')?></div>
		<div class="conts__sect">
			<div class="lk__indx"><?=$arResult['arUser']['PERSONAL_ZIP']?></div>
			<div class="lk__city"><?=$arResult['arUser']['PERSONAL_CITY']?></div>
			<div class="lk__street"><?=$arResult['arUser']['PERSONAL_STREET']?></div>
			<?/*<div class="lk__addr">
				<span class="l_home">д.5</span>, <span class="l_strd">с. 1</span>, <span class="l_appart">кв. 654</span>
			</div>*/?>
		</div>
		<div class="conts__edit-btn" onclick="editPersonalData(this);"><?=Loc::getMessage('EDIT_BUTTON_TITLE')?></div>
	</div>
</div>

<form method="post" name="form1" action="<?=$APPLICATION->GetCurUri()?>" enctype="multipart/form-data" role="form" style="display: none;">
	<?=$arResult["BX_SESSION_CHECK"]?>
	<input type="hidden" name="lang" value="<?=LANG?>" />
	<input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
	<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />
	<div class="flex-row priv__of-cols" id="user_div_reg">
		<div class="col__priv-r">
			<div class="p_of"><?=Loc::getMessage('CONTACTS_SUBSECTION_TITLE')?></div>
			<?/*<div class="main-profile-block-date-info">
					<?if ($arResult["ID"] > 0):?>
						<?if (strlen($arResult["arUser"]["TIMESTAMP_X"]) > 0):?>
							<div class="col-sm-9 col-md-offset-3 small">
								<strong><?=Loc::getMessage('LAST_UPDATE')?></strong>
								<strong><?=$arResult["arUser"]["TIMESTAMP_X"]?></strong>
							</div>
						<?endif;?>

						<?if (strlen($arResult["arUser"]["LAST_LOGIN"]) > 0):?>
							<div class="col-sm-9 col-md-offset-3 small">
								<strong><?=Loc::getMessage('LAST_LOGIN')?></strong>
								<strong><?=$arResult["arUser"]["LAST_LOGIN"]?></strong>
							</div>
						<?endif;?>
					<?endif;?>
				</div>*/?>

			<?/*if (!in_array(LANGUAGE_ID, array('ru', 'ua'))):?>
					<div class="form-group">
						<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></label>
						<div class="col-sm-12">
							<input class="form-control" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
						</div>
					</div>
				<?endif;*/?>

			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-last-name"><?=Loc::getMessage('LAST_NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-name"><?=Loc::getMessage('NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-second-name"><?=Loc::getMessage('SECOND_NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-email"><?=Loc::getMessage('EMAIL')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-phone"><?=Loc::getMessage('PERSONAL_PHONE')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="PERSONAL_PHONE" maxlength="50" id="main-profile-phone" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
				</div>
			</div>

			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-inn"><?=Loc::getMessage('UF_INN')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="UF_INN" maxlength="50" id="main-profile-inn" value="<?=$arResult["arUser"]["UF_INN"]?>" />
				</div>
			</div>

			<?/*if ($arResult['CAN_EDIT_PASSWORD']):?>
					<div class="form-group">
						<p class="main-profile-form-password-annotation col-sm-9 col-sm-offset-3 small">
							<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
						</p>
					</div>

					<div class="form-group">
						<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-password"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
						<div class="col-sm-12">
							<input class=" form-control bx-auth-input main-profile-password" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
						</div>
					</div>

					<div class="form-group">
						<label class="main-profile-form-label main-profile-password col-sm-12 col-md-3 text-md-right" for="main-profile-password-confirm">
							<?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?>
						</label>
						<div class="col-sm-12">
							<input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off" />
						</div>
					</div>
				<?endif;*/?>
			<input type="submit" name="save" class="conts__edit-btn" value="<?=(($arResult["ID"] > 0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
		</div>

		<div class="col__priv-r2">
			<div class="p_of"><?=Loc::getMessage('DELIVERY_ADDRESS_SUBSECTION_TITLE')?></div>
			<div class="conts__sect">
				<div class="form-group">
					<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-zip"><?=Loc::getMessage('PERSONAL_ZIP')?></label>
					<div class="col-sm-12">
						<input class="form-control" type="text" name="PERSONAL_ZIP" maxlength="50" id="main-profile-zip" value="<?=$arResult["arUser"]["PERSONAL_ZIP"]?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-city"><?=Loc::getMessage('PERSONAL_CITY')?></label>
					<div class="col-sm-12">
						<input class="form-control" type="text" name="PERSONAL_CITY" maxlength="50" id="main-profile-city" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="main-profile-form-label col-sm-12 col-md-3 text-md-right" for="main-profile-street"><?=Loc::getMessage('PERSONAL_STREET')?></label>
					<div class="col-sm-12">
						<input class="form-control" type="text" name="PERSONAL_STREET" maxlength="50" id="main-profile-street" value="<?=$arResult["arUser"]["PERSONAL_STREET"]?>" />
					</div>
				</div>
			</div>
			<input type="submit" name="save" class="conts__edit-btn" value="<?=(($arResult["ID"] > 0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
		</div>
	</div>
</form>

<div class="col-sm-12 main-profile-social-block">
	<?if ($arResult["SOCSERV_ENABLED"]) {
		$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
			"SHOW_PROFILES" => "Y",
			"ALLOW_DELETE" => "Y"
		),
			false
		);
	}?>
</div>

<div class="clearfix"></div>

<script>
	function editPersonalData(obj) {
		$(obj).closest('.flex-row').hide();
		$('#user_div_reg').closest('form').show();
	}
</script>