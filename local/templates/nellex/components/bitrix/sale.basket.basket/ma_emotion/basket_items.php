<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arResult
 */

use \Bitrix\Main\Localization\Loc;

//echo ShowError($arResult["ERROR_MESSAGE"]);
$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$rowCols = 0;
?>

<?if ($normalCount > 0):?>
	<?global $arBasketItems;?>

	<table class="colored" width="100%" id="cart__table">
		<thead>
		<tr class="cart__thead__row">
			<th class="cart__th-cel th-prod">Товар</th>
			<th class="cart__th-cel th-prod-info"></th>
			<th class="cart__th-cel th-color">Цвет</th>
			<th class="cart__th-cel th-size">Размер</th>
			<th class="cart__th-cel th-count">Кол-во</th>
			<th class="cart__th-cel th-prix">Цена</th>
			<th class="cart__th-cel th-discount">Скидка</th>
			<th class="cart__th-cel th-sum">Сумма</th>
			<th class="cart__th-cel th-del"></th>

			<?
			foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader) {
				if ($arHeader["id"] == "DELETE") {$bDeleteColumn = true;}
				if ($arHeader["id"] == "TYPE") {$bTypeColumn = true;}
				if ($arHeader["id"] == "QUANTITY") {$bQuantityColumn = true;}
				if ($arHeader["id"] == "DISCOUNT") {$bDiscountColumn = true;}
			}
			?>
		</tr>
		</thead>

		<tbody>
		<?foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):?>
			<?$currency = $arItem["CURRENCY"];?>
			<?if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):?>
				<?$arBasketItems[] = $arItem["PRODUCT_ID"];?>
				<tr class="cart__row" data-id="<?=$arItem["ID"]?>" data-product_id="<?=$arItem["PRODUCT_ID"]?>" data-iblockid="<?=$arItem["IBLOCK_ID"]?>" <?if($arItem["QUANTITY"]>$arItem["AVAILABLE_QUANTITY"]):?>data-error="no_amounth"<?endif;?>>
					<td class="cart__td-cel td-prod">
						<div class="im-basket" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"></a>
						</div>
					</td>

					<td class="cart__td-cel td-prod-info">
						<div class="basket__prod-name">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
							<?=strlen($arItem['PROPS_ALL']['BRAND']['VALUE']) ? $arItem['PROPS_ALL']['BRAND']['VALUE'].' | '.$arItem['NAME'] : $arItem['NAME']?>
							</a>
						</div>
						<div class="basket__prod-art"><?=$arItem['PROPS_ALL']['VENDOR_CODE']['VALUE'] ? $arItem['PROPS_ALL']['VENDOR_CODE']['NAME'].': '.$arItem['PROPS_ALL']['VENDOR_CODE']['VALUE'] : ''?></div>
						<div class="basket__prod-contents">
							<?=$arItem['PROPS_ALL']['COMPOSITION']['VALUE'] ? $arItem['PROPS_ALL']['COMPOSITION']['NAME'].': '.$arItem['PROPS_ALL']['COMPOSITION']['VALUE'] : ''?>
						</div>
					</td>

					<td class="cart__td-cel td-color">
						<?
						$arColor = explode(',', $arItem['PROPERTY_COLOR_VALUE']);
						$arColorName = explode(',', $arItem['PROPERTY_COLOR_VALUE_DISPLAY']);
						?>
						<?if (count($arColor)):?>
                            <div class="color__sel-holder">
                                <?foreach ($arColor as $key => $item):?>
                                        <label for="<?='color_'.$arItem["ID"].'_'.$key?>">
                                            <input id="<?='color_'.$arItem["ID"].'_'.$key?>"
                                                   type="radio"
                                                   name="<?='color_'.$arItem["ID"]?>"
                                                   value="<?=trim($item)?>"
                                                   onchange="changePropBasket('<?=$arItem["ID"]?>', '<?=$arItem['PROPS_ALL']['COLOR']['ID']?>', '<?=trim($item)?>')"
                                                <?if (trim($item) == $arItem['PROPS_ALL']['COLOR']['VALUE']) echo 'checked'?>
                                                />
                                            <span class="imd-colord im-colord02" style="background-image: url('<?=$arItem['PROPERTY_COLOR_SRC'][$key]?>');" title="<?=trim($arColorName[$key])?>"></span>
                                        </label>
                                <?endforeach;?>
                            </div>
						<?endif;?>
						<?unset($arColor);?>
							<?/*<span class="color-selector">
                            <label class="color-bask-checkd">
								<input class="csdsz-lbx" type="radio" name="color" value="1">
								<span class="checkds-labl"></span>
								<span class="imd-colord im-colord01"></span>
							</label>
                            <label class="color-bask-checkd">
								<input class="csdsz-lbx" type="radio" name="color" value="2">
								<span class="checkds-labl"></span>
								<span class="imd-colord im-colord02"></span>
							</label>
                            <label class="color-bask-checkd">
								<input class="csdsz-lbx" type="radio" name="color" value="3">
								<span class="checkds-labl"></span>
								<span class="imd-colord im-colord03"></span>
							</label>
                        	</span>*/?>
					</td>

					<td class="cart__td-cel td-size">
						<div class="color__sel-holder">
							<?$arSize = explode(',', $arItem['PROPERTY_SIZE_VALUE']);?>
							<?if (count($arSize)):?>
								<?foreach ($arSize as $key => $item):?>
									<label for="<?='size_'.$arItem["ID"].'_'.$key?>">
										<input id="<?='size_'.$arItem["ID"].'_'.$key?>"
											   type="radio"
											   name="<?='size_'.$arItem["ID"]?>"
											   value="<?=trim($item)?>"
											   onchange="changePropBasket('<?=$arItem["ID"]?>', '<?=$arItem['PROPS_ALL']['SIZE']['ID']?>', '<?=trim($item)?>')"
											   <?if (trim($item) == $arItem['PROPS_ALL']['SIZE']['VALUE']) echo 'checked'?>
											/>
										<span class="size-select__xs"><?=trim($item)?></span>
									</label>
								<?endforeach;?>
							<?endif;?>
							<?unset($arSize);?>
                        <?/*<span class="size-selector">
                            <span class="size-select__xs">56</span>
                            <span class="size-select__xs">58</span>
                            <span class="size-select__xs">60</span>
                        </span>*/?>
						</div>
					</td>

					<td class="cart__td-cel td-count">
                    <span class="flex-row insized">
						<?
						$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 1;
						$tmp_ratio = 0;
						$tmp_ratio += $ratio;

						$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
						if (!isset($arItem["MEASURE_RATIO"])){
							$arItem["MEASURE_RATIO"] = 1;
						}
						?>

						<?if (isset($arItem["AVAILABLE_QUANTITY"])):?>
							<a href="javascript:void(0);" onclick="setQuantity('<?=$arItem["ID"]?>', '<?=$arItem["MEASURE_RATIO"]?>', 'down')" class="minuszd">-</a>
						<?endif;?>

						<input
							type="text"
							class="in-amt"
							id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
							name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
							data-id="<?=$arItem["ID"];?>"
							step="1"
							min="1"
							<?=$max?>
							step="<?=$ratio?>"
							value="<?=$arItem["QUANTITY"]?>"
							onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', '<?=$ratio?>')"
							>

						<?if (isset($arItem["AVAILABLE_QUANTITY"])):?>
							<a href="javascript:void(0);" onclick="setQuantity('<?=$arItem["ID"]?>', '<?=$arItem["MEASURE_RATIO"]?>', 'up')" class="pluszd">+</a>
						<?endif;?>

						<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />

						<?if ($arItem['CHECK_MAX_QUANTITY'] !== 'N' && $arItem["QUANTITY"] > $arItem["AVAILABLE_QUANTITY"]):?>
							<div class="error"><?=Loc::getMessage("NO_NEED_AMMOUNT")?></div>
						<?endif;?>
                    </span>
					</td>

					<td class="cart__td-cel td-prix">
                    	<span class="basket__prix-d"><?=$arItem["PRICE_FORMATED"]?></span>
						<input type="hidden" name="item_price_<?=$arItem["ID"]?>" value="<?=$arItem["PRICE"]?>" />
						<input type="hidden" name="item_summ_<?=$arItem["ID"]?>" value="<?=$arItem["PRICE"]*$arItem["QUANTITY"]?>" />
					</td>

					<td class="cart__td-cel td-discount">
						<?if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0) :?>
							<span class="basket__dcd">-<?=$arItem["DISCOUNT_PRICE_PERCENT"]?>%</span>
							<input type="hidden" name="item_price_discount_<?=$arItem["ID"]?>" value="<?=$arItem["FULL_PRICE"]?>" />
						<?endif;?>
					</td>

					<td class="cart__td-cel td-sum">
						<span class="final-amt"><?=$arItem["SUMM_FORMATED"]?></span>
					</td>

					<td class="cart__td-cel td-del">
						<a href="javascript:void(0);" class="del-btn" title="<?=Loc::getMessage("SALE_DELETE")?>" onclick="deleteItemFromBasket('<?=$arItem["PRODUCT_ID"]?>')"></a>
					</td>
				</tr>
			<?endif;?>
		<?endforeach;?>

		<?
		$arTotal = array();
		if ($bWeightColumn) {
			$arTotal["WEIGHT"]["NAME"] = Loc::getMessage("SALE_TOTAL_WEIGHT");
			$arTotal["WEIGHT"]["VALUE"] = $arResult["allWeight_FORMATED"];
		}

		if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") {
			$arTotal["VAT_EXCLUDED"]["NAME"] = Loc::getMessage("SALE_VAT_EXCLUDED"); $arTotal["VAT_EXCLUDED"]["VALUE"] = $arResult["allSum_wVAT_FORMATED"];
			$arTotal["VAT_INCLUDED"]["NAME"] = Loc::getMessage("SALE_VAT_INCLUDED"); $arTotal["VAT_INCLUDED"]["VALUE"] = $arResult["allVATSum_FORMATED"];
		}

		if (doubleval($arResult["DISCOUNT_PRICE_ALL"]) > 0) {
			$arTotal["PRICE"]["NAME"] = Loc::getMessage("SALE_TOTAL");
			$arTotal["PRICE"]["VALUES"]["ALL"] = $arResult["allSum_FORMATED"];
			$arTotal["PRICE"]["VALUES"]["WITHOUT_DISCOUNT"] = $arResult["PRICE_WITHOUT_DISCOUNT"];
		} else {
			$arTotal["PRICE"]["NAME"] = Loc::getMessage("SALE_TOTAL");
			$arTotal["PRICE"]["VALUES"]["ALL"] = $arResult["allSum_FORMATED"];
		}
		?>

		<tr class="cart__row">
			<td class="cart__td-cel" colspan="6">
				<a href="<?=PATH_TO_CATALOG?>" class="cart__add-prod">+ Добавить товар</a>
			</td>
			<td class="cart__td-cel td-discount itg"></td>
			<td class="cart__td-cel td-sum itg"></td>
			<td class="cart__td-cel td-del"></td>
		</tr>

		<tr class="cart__row">
			<td class="cart__td-cel-o" colspan="6"></td>

			<td class="cart__td-cel-o td-discount itg">
				<?foreach($arTotal as $key => $value):?>
					<?if ($value["VALUES"] && $value["NAME"]):?>
						<div class="itogd"><?=$value["NAME"]?>:</div>
					<?endif;?>
				<?endforeach;?>
			</td>

			<td class="cart__td-cel-o td-sum itg">
				<?foreach($arTotal as $key => $value):?>
					<?if ($value["VALUES"] && $value["NAME"]):?>
						<?if ($key == "PRICE"):?>
							<?if ($arResult["DISCOUNT_PRICE_ALL"]):?>
								<?/*<div data-type="price_discount">
									<div class="price discount"><strike><?=$value["VALUES"]["WITHOUT_DISCOUNT"];?></strike></div>
									<div class="price"><?=$value["VALUES"]["ALL"];?></div>
								</div>*/?>
								<div class="final-amt itg"><?=$value["VALUES"]["ALL"];?></div>
							<?else:?>
								<div class="final-amt itg"><?=$arResult["allSum_FORMATED"];?></div>
							<?endif;?>
						<?elseif ($value["VALUE"]):?>
							<div data-type="<?=strToLower($key)?>" class="final-amt itg"><?=$value["VALUE"]?></div>
						<?endif;?>
					<?endif;?>
				<?endforeach;?>
				<?/*<span class="final-amt itg">655 руб</span>*/?>
			</td>

			<td class="cart__td-cel-o td-del"></td>
		</tr>
		</tbody>
	</table>
<?else:?>
	<div class="cart_empty">
		<table cellspacing="0" cellpadding="0" width="100%" border="0">
			<tr>
				<td class="img_wrapp">
					<div class="img"></div>
				</td>
				<td>
					<div class="text">
						<?$APPLICATION->IncludeFile(SITE_DIR."include/empty_fly_cart.php", Array(), Array(
							"MODE" => "html",
							"NAME"=> Loc::getMessage("SALE_BASKET_EMPTY"),));?>
					</div>
				</td>
			</tr>
		</table>
		<div class="clearboth"></div>
	</div>
<?endif;?>
<?//PR($arResult);?>
