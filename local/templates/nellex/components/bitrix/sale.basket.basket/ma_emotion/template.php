<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 */

use \Bitrix\Main\Localization\Loc;

$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
//$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
//$compareCount = count($_SESSION["CATALOG_COMPARE_LIST"][CNextCache::$arIBlocks[SITE_ID]['aspro_next_catalog']['aspro_next_catalog'][0]]["ITEMS"]);
$arParamsExport = $arParams;
unset($arParamsExport['INNER']);
$paramsString = urlencode(serialize($arParamsExport));

// update basket counters
//\Bitrix\Main\Loader::includeModule('aspro.next');
//$title_basket =  ($normalCount ? GetMessage("BASKET_COUNT", array("#PRICE#" => $arResult['allSum_FORMATED'])) : GetMessage("EMPTY_BLOCK_BASKET"));
//$title_delay = ($delayCount ? GetMessage("BASKET_DELAY_COUNT", array("#PRICE#" => $arResult["DELAY_PRICE"]["SUMM_FORMATED"])) : GetMessage("EMPTY_BLOCK_DELAY"));
//
//$arCounters = CNext::updateBasketCounters(array('READY' => array('COUNT' => $normalCount, 'TITLE' => $title_basket, 'HREF' => $arParams["PATH_TO_BASKET"]), 'DELAY' => array('COUNT' => $delayCount, 'TITLE' => $title_delay, 'HREF' => $arParams["PATH_TO_BASKET"].'#delayed'), 'COMPARE' => array('COUNT' => $compareCount, 'HREF' => $arParams["PATH_TO_COMPARE"]), 'PERSONAL' => array('HREF' => $arParams["PATH_TO_AUTH"])));

if ($arParams['INNER'] !== true && $_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo '<div class="basket-container'.(strlen($arResult["ERROR_MESSAGE"]) > 0 ? ' basket_empty' : '').'">';
}?>

<?$frame = $this->createFrame()->begin('');?>
<input type="hidden" name="total_price" value="<?=$arResult['allSum_FORMATED']?>" />
<input type="hidden" name="total_discount_price" value="<?=$arResult['allSum_FORMATED']?>" />
<input type="hidden" name="total_count" value="<?=$normalCount;?>" />

<?
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/functions.php");

$arUrls = Array(
	"delete" => SITE_DIR."ajax/show_basket_fly.php?action=delete&id=#ID#",
	"delay" => SITE_DIR."ajax/show_basket_fly.php?action=delay&id=#ID#",
	"add" => SITE_DIR."ajax/show_basket_fly.php?action=add&id=#ID#"
);

if (is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"])) {
	foreach ($arResult["WARNING_MESSAGE"] as $v) {
		echo ShowError($v);
	}
}

$arMenu = array(
	array(
		"ID" => "AnDelCanBuy",
		"TITLE" => Loc::getMessage("SALE_BASKET_ITEMS"),
		"COUNT" => $normalCount,
		"FILE" => "/basket_items.php"
	)
);

//	if ($delayCount) { $arMenu[] = array("ID"=>"DelDelCanBuy", "TITLE"=>GetMessage("SALE_BASKET_ITEMS_DELAYED"), "COUNT"=>$delayCount, "FILE"=>"/basket_items_delayed.php"); }
//	if ($subscribeCount) { $arMenu[] = array("ID"=>"ProdSubscribe", "TITLE"=>GetMessage("SALE_BASKET_ITEMS_SUBSCRIBED"), "COUNT"=>$subscribeCount, "FILE"=>"/basket_items_subscribed.php"); }
if ($naCount) {
	$arMenu[] = array(
		"ID" => "nAnCanBuy",
		"TITLE" => Loc::getMessage("SALE_BASKET_ITEMS_NOT_AVAILABLE"),
		"COUNT" => $naCount,
		"FILE" => "/basket_items_not_available.php");
}

?>

<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form" class="basket_wrapp">
	<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");?></li>
	<input id="fly_basket_params" type="hidden" name="PARAMS" value='<?=$paramsString?>' />
</form>

<?/*<script>
	<?if ($arParams["AJAX_MODE_CUSTOM"]=="Y"):?>
	var animateRow = function(row) {
		$(row).find("td.thumb-cell img").css({"maxHeight": "inherit", "maxWidth": "inherit"}).fadeTo(50, 0);
		var columns = $(row).find("td");
		$(columns).wrapInner('<div class="slide"></div>');
		$(row).find(".summ-cell").wrapInner('<div class="slide"></div>');
		setTimeout(function(){$(columns).animate({"paddingTop": 0, "paddingBottom": 0}, 50)}, 0);
		$(columns).find(".slide").slideUp(333);
	};

	$("#basket_form").ready(function() {
		$('form[name^=basket_form] .counter_block input[type=text]').change(function(e) {
			e.preventDefault();
		});

		$('form[name^=basket_form] .remove').unbind('click').click(function(e){
			e.preventDefault();
			var row = $(this).parents("tr").first();
			row.fadeTo(100 , 0.05, function() {});
			deleteProduct($(this).parents("tr[data-id]").attr('data-id'), $(this).parents("li").attr("item-section"), $(this).parents("tr[data-id]").attr('product-id'), $(this).parents("tr[data-id]"));
			markProductRemoveBasket($(this).parents("tr[data-id]").attr('product-id'));
			return false;
		});
	});
	<?endif;?>
</script>*/?>

<?
if (\Bitrix\Main\Loader::includeModule("currency")) {
	CJSCore::Init(array('currency'));
	$currencyFormat = CCurrencyLang::GetFormatDescription(CSaleLang::GetLangCurrency(SITE_ID));
}
?>

<?/*<script type="text/javascript">
	<?if (is_array($currencyFormat)):?>
	function jsPriceFormat(_number){
		BX.Currency.setCurrencyFormat('<?=CSaleLang::GetLangCurrency(SITE_ID);?>', <? echo CUtil::PhpToJSObject($currencyFormat, false, true); ?>);
		return BX.Currency.currencyFormat(_number, '<?=CSaleLang::GetLangCurrency(SITE_ID);?>', true);
	}
	<?endif;?>
</script>*/?>

<?$frame->end();?>

<?if($arParams['INNER'] !== true && $_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo '</div>';
}?>

<?
//PR($arParams);
//PR($arResult);
?>
