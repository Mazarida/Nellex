<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arItem
 */
?>

<div class="flex-row header__nav">
	<?if (!empty($arResult)):?>
		<?foreach($arResult as $arItem):?>
			<?if($arParams["MAX_LEVEL"] == 2 && $arItem["DEPTH_LEVEL"] > 1) continue;?>
			<a class="header__nav-lnk <?if ($arItem["SELECTED"]) echo 'selected';?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
		<?endforeach;?>
	<?endif;?>
</div>
