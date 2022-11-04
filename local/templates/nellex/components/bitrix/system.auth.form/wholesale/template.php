<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arResult
 * @var array $arParams
 */

use Bitrix\Main\Localization\Loc;

CJSCore::Init();
?>

<div class="bx-system-auth-form">
	<?if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']) ShowMessage($arResult['ERROR_MESSAGE']);?>

	<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="login__form">
		<?if ($arResult["BACKURL"] <> ''):?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif;?>

		<?foreach ($arResult["POST"] as $key => $value):?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach;?>

		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />

		<input class="login__input-f" type="text" name="USER_LOGIN" value="" placeholder="<?=Loc::getMessage("AUTH_LOGIN")?>">
		<script>
			BX.ready(function() {
				var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
				if (loginCookie)
				{
					var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
					var loginInput = form.elements["USER_LOGIN"];
					loginInput.value = loginCookie;
				}
			});
		</script>

		<input class="login__input-f" type="password" name="USER_PASSWORD" autocomplete="off" placeholder="<?=Loc::getMessage("AUTH_PASSWORD")?>">
		<?if ($arResult["SECURE_AUTH"]):?>
			<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?=Loc::getMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
			<noscript>
				<span class="bx-auth-secure" title="<?=Loc::getMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
			</noscript>
			<script type="text/javascript">
				document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
			</script>
		<?endif;?>

		<?/*if ($arResult["STORE_PASSWORD"] == "Y"):?>
				<tr>
					<td valign="top"><input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" /></td>
					<td width="100%"><label for="USER_REMEMBER_frm" title="<?=Loc::getMessage("AUTH_REMEMBER_ME")?>"><?echo Loc::getMessage("AUTH_REMEMBER_SHORT")?></label></td>
				</tr>
			<?endif;*/?>

		<?/*if ($arResult["CAPTCHA_CODE"]):?>
				<tr>
					<td colspan="2">
						<?echo Loc::getMessage("AUTH_CAPTCHA_PROMT")?>:<br />
						<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
						<input type="text" name="captcha_word" maxlength="50" value="" /></td>
				</tr>
			<?endif;*/?>

		<noindex><a href="<?=PATH_TO_RECOVERY_PASSWORD_WHOLESALE?>" class="forgot-pass" rel="nofollow"><?=Loc::getMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex>

		<button class="login__submit" type="submit" name="Login" value="<?=Loc::getMessage("AUTH_LOGIN_BUTTON")?>"><?=Loc::getMessage("AUTH_LOGIN_BUTTON")?></button>

		<?if ($arResult["AUTH_SERVICES"]):?>
			<tr>
				<td colspan="2">
					<div class="bx-auth-lbl"><?=Loc::getMessage("socserv_as_user_form")?></div>
					<?
					$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
						array(
							"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
							"SUFFIX"=>"form",
						),
						$component,
						array("HIDE_ICONS"=>"Y")
					);
					?>
				</td>
			</tr>
		<?endif;?>
	</form>

	<?if($arResult["AUTH_SERVICES"]):?>
		<?
		$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
			array(
				"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
				"AUTH_URL"=>$arResult["AUTH_URL"],
				"POST"=>$arResult["POST"],
				"POPUP"=>"Y",
				"SUFFIX"=>"form",
			),
			$component,
			array("HIDE_ICONS"=>"Y")
		);
		?>
	<?endif?>
</div>
