<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Localization\Loc;
?>

<div class="subs__f-title"><?=Loc::getMessage('SUBSCRIBE_FORM_TITLE')?></div>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post" class="subscrib-form">
	<?echo bitrix_sessid_post();?>
	<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
		<input type="hidden" name="RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>" />
	<?endforeach;?>

	<input type="hidden" name="FORMAT" value="html" />

	<label class="checkd__news-only">
		<input class="styld-checks" type="checkbox" name="news_only" />
		<span class="styld-check-ent"><span class="pseudo"></span></span>
		<span class="labl-nws-o"><?=Loc::getMessage('SUBSCRIBE_FORM_ONLY_PRODUCTS_TEXT')?></span>
	</label>

	<div class="flex-row subs-in-sbn">
		<input type="text" name="EMAIL" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"] != "" ? $arResult["SUBSCRIPTION"]["EMAIL"] : $arResult["REQUEST"]["EMAIL"]?>" class="subs__txt-in" />
		<button class="subs__submit" type="submit" name="Save" value="<?=Loc::getMessage("subscr_subscr")?>"><?=Loc::getMessage("subscr_subscr")?></button>
	</div>
</form>

<script>
	$(document).ready(function() {
		$('input[name="news_only"]').on('change', function() {
			if ($(this).is(':checked')) {
				$('#sf_RUB_ID_1').val('');
			} else {
				$('#sf_RUB_ID_1').val('1');
			}
		});
	});
</script>
