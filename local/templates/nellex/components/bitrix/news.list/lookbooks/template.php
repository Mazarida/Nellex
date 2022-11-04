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

$this->setFrameMode(true);
?>

<div class="flex-row looks__books">
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?><br />
	<?endif;?>

	<?foreach ($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>

		<div class="flex-row lookbook__col">
			<div class="look-desc">
				<div class="look-text"><?=str_replace(' ', '<br>', $arItem["NAME"])?></div>
				<a href="<?=CFile::GetPath($arItem["PROPERTIES"]["FILE"]["VALUE"])?>" class="look-link" download><?=Loc::getMessage('DOWNLOAD_LINK_TEXT')?></a>
			</div>

			<div class="look-img" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')"></div>
		</div>
	<?endforeach;?>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
