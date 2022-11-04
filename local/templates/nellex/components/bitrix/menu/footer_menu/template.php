<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arItem
 */
?>

<?foreach($arResult as $chunk):?>
	<div class="foots__nav">
		<?if (!empty($arResult)):?>
			<?foreach($chunk as $arItem):?>
				<?if($arParams["MAX_LEVEL"] == 2 && $arItem["DEPTH_LEVEL"] > 1) continue;?>
				<a class="foots__nav-link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
			<?endforeach;?>
		<?endif;?>
	</div>
<?endforeach;?>
