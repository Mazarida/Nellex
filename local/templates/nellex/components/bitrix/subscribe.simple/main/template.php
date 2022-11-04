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

<?if (count($arResult["ERRORS"]) > 0):?>
	<?foreach($arResult["ERRORS"] as $strError):?>
		<p class="errortext"><?echo $strError?></p>
	<?endforeach;?>
	<?$this->setFrameMode(false);?>
<?elseif (count($arResult["RUBRICS"]) <= 0):?>
	<p class="errortext"><?=Loc::getMessage("CT_BSS_NO_RUBRICS_FOUND")?></p>
	<?$this->setFrameMode(false);?>
<?else:?>
	<?$frame=$this->createFrame()->begin();?>
	<?if($arResult["MESSAGE"]):?>
		<p class="notetext"><?echo $arResult["MESSAGE"]?></p>
	<?endif;?>

	<form method="POST" action="<?=$arResult["FORM_ACTION"]?>">
		<table class="data-table">
			<tbody>
			<tr>
				<td>
					<?foreach($arResult["RUBRICS"] as $arRubric):?>
						<input name="RUB_ID[]" value="<?=$arRubric["ID"]?>" id="RUB_<?=$arRubric["ID"]?>" type="checkbox" <?if($arRubric["CHECKED"]) echo "checked";?>><label for="RUB_<?=$arRubric["ID"]?>"><?=$arRubric["NAME"]?></label><br>
					<?endforeach?>
					<br>
					<input name="FORMAT" value="text" id="FORMAT_text" type="radio" <?if($arResult["FORMAT"] === "text") echo "checked";?>><label for="FORMAT_text"><?=Loc::getMessage("CT_BSS_TEXT")?></label>
					&nbsp;/&nbsp;
					<input name="FORMAT" value="html" id="FORMAT_html" type="radio" <?if($arResult["FORMAT"] === "html") echo "checked";?>><label for="FORMAT_html"><?=Loc::getMessage("CT_BSS_HTML")?></label>
				</td>
			</tr>
			</tbody>
			<tfoot>
			<tr>
				<td>
					<?=bitrix_sessid_post();?>
					<input type="submit" name="Update" value="<?=Loc::getMessage("CT_BSS_FORM_BUTTON")?>">
				</td>
			</tr>
			</tfoot>
		</table>
	</form>

	<?$frame->beginStub();?>

	<form method="POST" action="<?=$arResult["FORM_ACTION"]?>">
		<table class="data-table">
			<tbody>
			<tr>
				<td>
					<?foreach($arResult["RUBRICS"] as $arRubric):?>
						<input name="RUB_ID[]" value="<?echo $arRubric["ID"]?>" id="RUB_<?=$arRubric["ID"]?>" type="checkbox"><label for="RUB_<?=$arRubric["ID"]?>"><?=$arRubric["NAME"]?></label><br>
					<?endforeach?>
					<br>
					<input name="FORMAT" value="text" id="FORMAT_text" type="radio"><label for="FORMAT_text"><?=Loc::getMessage("CT_BSS_TEXT")?></label>
					&nbsp;/&nbsp;
					<input name="FORMAT" value="html" id="FORMAT_html" type="radio"><label for="FORMAT_html"><?=Loc::getMessage("CT_BSS_HTML")?></label>
				</td>
			</tr>
			</tbody>
			<tfoot>
			<tr>
				<td>
					<input type="submit" name="Update" value="<?=Loc::getMessage("CT_BSS_FORM_BUTTON")?>">
				</td>
			</tr>
			</tfoot>
		</table>
	</form>
	
	<?$frame->end();?>
<?endif;?>

<?//PR($arResult);?>
