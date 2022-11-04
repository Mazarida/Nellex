<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc;
?>

<?if(strlen($arResult["ERROR_MESSAGE"])):?>
	<?=ShowError($arResult["ERROR_MESSAGE"]);?>
<?else:?>
	<div style="text-align: center; font-family: Arial, sans-serif; font-size: 16px;">
		<div style="background-image: url('//<?=$_SERVER['HTTP_HOST']?>/images/mail/nvs.jpg');">
			<table width="1100" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto; table-layout: fixed;">
				<tr>
					<td width="22%" style="vertical-align: top; padding: 40px 0; text-align: left;">
						<img style="max-width: 100%; height: auto;" src="//<?=$_SERVER['HTTP_HOST']?>/images/mail/nlx__logo.png" width="140" alt="">
					</td>
					<td width="56%" style="padding: 40px 0;">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image: url('//<?=$_SERVER['HTTP_HOST']?>/images/mail/banner.png'); background-size: cover; background-position: right; margin: 0 auto; table-layout: fixed;">
							<tr>
								<td style="padding: 40px;" width="50%">
									<table width="100%;" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto; background: #FFFFFF;">
										<tr>
											<td style="padding: 20px 0;">
												<p><?=Loc::getMessage('SPOD_ORDER_SUCCESS_TEXT')?></p>
												<p><?=Loc::getMessage('SPOD_THANKS_TEXT')?></p>
												<a style="display: inline-block; margin-top:1em; margin-bottom: 2em;background: #000;color: #FFF;padding: 10px;text-decoration: none;text-transform: uppercase;width: 170px;font-size: 12px;" href="//<?=$_SERVER['HTTP_HOST']?>/catalog/"><?=Loc::getMessage('SPOD_GO_CATALOG_TEXT')?></a>
											</td>
										</tr>
									</table>
								</td>
								<td width="50%"></td>
							</tr>
						</table>
					</td>
					<td width="22%" style="vertical-align: top; padding: 45px 0; text-align: right;"><b><?=Loc::getMessage('SPOD_ORDER_SUCCESS_TEXT1')?></b></td>
				</tr>
			</table>
		</div>
	</div>

	<p style="width:1100px; max-width: 100%; margin: 0 auto;padding-top: 11px; text-align: left;"><b><?=Loc::getMessage('SPOD_ORDER_NUMBER_TEXT')?> <?=$arResult['ACCOUNT_NUMBER']?></b> ЗАКАЗЧИК: <?=htmlspecialcharsbx($arResult["USER_NAME"])?>,  E-mail: <?=htmlspecialcharsbx($arResult["USER"]["EMAIL"])?>,  Тел.: <?=htmlspecialcharsbx($arResult["USER"]["PERSONAL_PHONE"])?>, ИНН: <?=htmlspecialcharsbx($arResult["USER"]["INN"])?>.</p>
	<table width="1100" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto; table-layout: fixed;">
		<?foreach($arResult["BASKET"] as $prod):?>
			<tr>
				<td width="18%" style="padding: 30px 0; vertical-align: top; border-bottom: 1px solid #222222;">
					<img width="115" style="max-width: 100%; height: auto;" src="//<?=$_SERVER['HTTP_HOST'].$prod['PICTURE']['SRC']?>" alt="">
				</td>
				<td width="27%" style="text-align: left;padding: 30px 0 0; vertical-align: top; border-bottom: 1px solid #222222;">
					<p style="margin-top: 0;"><?=$prod["PROPS"][1]["VALUE"]?> | <?=$prod["NAME"]?></p>
					<p style="font-size: 12px;">Артикул: <?=$prod["PROPERTY_VENDOR_CODE_VALUE"]?></p>
					<p style="font-size: 12px;"><?=$prod["PROPERTY_COMPOSITION_VALUE"]?></p>
				</td>
				<td width="29%" style="text-align: left;padding: 30px 0 0; vertical-align: top; border-bottom: 1px solid #222222;">
					<p style="margin-top: 0;">АДРЕС ДОСТАВКИ</p>
					<p style="font-size: 12px;"><?=$arResult['DELIVERY_ZIP']?><br><?=$arResult['DELIVERY_CITY']?><br><?=$arResult['DELIVERY_ADDRESS']?></p>
				</td>
				<td width="26%" style="text-align: left;padding: 30px 0 0; vertical-align: top; border-bottom: 1px solid #222222;">
					<p style="margin-top: 0;">
						ДОСТАВКА
					</p>
					<p style="font-size: 12px;">
						<?=$arResult['SHIPMENT'][0]['DELIVERY_NAME']?>
					</p>
				</td>
			</tr>
		<?endforeach;?>
		<tr>
			<td width="18%" style="padding: 30px 0; vertical-align: top; border-top: 2px solid #666666;">
			</td>
			<td width="27%" style="text-align: left;padding: 30px 0; vertical-align: top; border-top: 2px solid #666666;">
				<p style="margin-top: 0;">ОПЛАТА</p>
				<p><?=$arResult['PAYMENT'][$arResult['ID']]['PAY_SYSTEM_NAME']?></p>
			</td>
			<td width="29%" style="text-align: left;padding: 30px 0; vertical-align: top; border-top: 2px solid #666666;">
				<p style="margin-top: 0;">К ОПЛАТЕ</p>
				<p><b style="text-transform: uppercase;"><?=$arResult["PRICE_FORMATED"]?></b></p>
			</td>
			<td width="26%" style="text-align: left;padding: 30px 0; vertical-align: top; border-top: 2px solid #666666;">
				<a href="//<?=$_SERVER['HTTP_HOST']?>/personal/history/" style="display: inline-block;color: #000;background: #e6f5ee;text-decoration: none;text-transform: uppercase;font-weight: 600;font-size: 11px;padding: 16px 0;width: 200px;text-align: center;">Отследить заказ</a>
			</td>
		</tr>
	</table>
<?endif;?>

<?//PR($arResult);?>