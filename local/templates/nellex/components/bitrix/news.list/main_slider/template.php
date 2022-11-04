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

<div class="swiper-wrapper sc1__sl-wrapper">
	<?foreach ($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>

		<div class="flex-row swiper-slide sc1__slide">
			<div class="sc1__sl-ls">
				<div class="sc1__sl-head"><?=$arItem["NAME"]?></div>
				<div class="sc1__sl-logo" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')"></div>
				<div class="sc1__sl-slug"><?=$arItem["PREVIEW_TEXT"]?></div>
				<a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>" class="sc1__sl-btn"><?=$arItem["PROPERTIES"]["LINK"]["DESCRIPTION"]?></a>
			</div>

			<div class="sc1__sl-rs">
				<div class="sc1__r-im" style="background-image: url('<?=$arItem["DETAIL_PICTURE"]["SRC"]?>')"></div>
			</div>
		</div>
	<?endforeach;?>
</div>

<div class="swiper-pagination home__sc1-pag"></div>
