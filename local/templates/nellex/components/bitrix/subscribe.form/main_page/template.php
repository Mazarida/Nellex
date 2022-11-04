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

<div class="subscribe-form"  id="subscribe-form">
	<div class="subs__f-title"><?=Loc::getMessage('SUBSCRIBE_FORM_TITLE')?></div>

	<?$frame = $this->createFrame("subscribe-form", false)->begin();?>
	<form action="<?=$arResult["FORM_ACTION"]?>" class="subscrib-form">
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<input type="hidden" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>" />
		<?endforeach;?>

		<label class="checkd__news-only">
			<input class="styld-checks" type="checkbox" name="news_only" />
			<span class="styld-check-ent"><span class="pseudo"></span></span>
			<span class="labl-nws-o"><?=Loc::getMessage('SUBSCRIBE_FORM_ONLY_PRODUCTS_TEXT')?></span>
		</label>

		<div class="flex-row subs-in-sbn">
			<input type="text" name="sf_EMAIL" value="<?=$arResult["EMAIL"]?>" class="subs__txt-in" />
			<button class="subs__submit" type="submit" name="OK" value="<?=Loc::getMessage("subscr_form_button")?>"><?=Loc::getMessage("subscr_form_button")?></button>
		</div>
	</form>
	<?$frame->beginStub();?>
	<form action="<?=$arResult["FORM_ACTION"]?>" class="subscrib-form">

		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<input type="hidden" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>" />
		<?endforeach;?>

		<label class="checkd__news-only">
			<input class="styld-checks" type="checkbox" name="news_only" />
			<span class="styld-check-ent"><span class="pseudo"></span></span>
			<span class="labl-nws-o"><?=Loc::getMessage('SUBSCRIBE_FORM_ONLY_PRODUCTS_TEXT')?></span>
		</label>

		<div class="flex-row subs-in-sbn">
			<input type="text" name="sf_EMAIL" value="<?=$arResult["EMAIL"]?>" class="subs__txt-in" />
			<button class="subs__submit" type="submit" name="OK" value="<?=Loc::getMessage("subscr_form_button")?>"><?=Loc::getMessage("subscr_form_button")?></button>
		</div>
	</form>
	<?$frame->end();?>
</div>

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
