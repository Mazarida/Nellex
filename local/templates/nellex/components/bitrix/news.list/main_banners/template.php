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

$this->setFrameMode(true);
?>

<div class="flex-row sc2__banner-rowd">
	<?foreach ($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>

		<div class="sc2__banner-t">
			<div class="sc2__banner-txt">
				<div class="sc2__banner-head"><?=$arItem["NAME"]?></div>
				<div class="sc2__banner-subhead"><?=$arItem["PREVIEW_TEXT"]?></div>
				<a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>" class="sc2__banner-link"><?=$arItem["PROPERTIES"]["LINK"]["DESCRIPTION"]?></a>
			</div>

			<div class="sc2__banner-im" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')"></div>
		</div>
	<?endforeach;?>
</div>
