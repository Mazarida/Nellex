<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer) {
		if ($offer['MORE_PHOTO_COUNT'] > 1) {
			$showSliderControls = true;
			break;
		}
	}
} else {
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION'])) {
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos) {
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION'])) {
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos) {
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>

	<div class="prod-info-holder" id="<?=$itemIds['ID']?>" itemscope itemtype="http://schema.org/Product">
		<div class="flex-row prod-bg-wrapper">
			<div class="prod-img-big" id="<?=$itemIds['BIG_SLIDER_ID']?>">
				<span class="product-item-detail-slider-close" data-entity="close-popup"></span>
				<div class="product-item-detail-slider-images-container" data-entity="images-container">
					<?if (!empty($actualItem['MORE_PHOTO'])):?>
						<?foreach ($actualItem['MORE_PHOTO'] as $key => $photo):?>
							<div class="product-item-detail-slider-image<?=($key == 0 ? ' active' : '')?>" data-entity="image" data-id="<?=$photo['ID']?>">
								<img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>"<?=($key == 0 ? ' itemprop="image"' : '')?>>
							</div>
						<?endforeach;?>
					<?endif;?>
				</div>
			</div>

			<?if ($showSliderControls):?>
				<div class="prod__gallery_col" id="<?=$itemIds['SLIDER_CONT_ID']?>">
					<?if (!empty($actualItem['MORE_PHOTO'])):?>
						<?foreach ($actualItem['MORE_PHOTO'] as $key => $photo):?>
							<div class="prod__gallery-im-sm product-item-detail-slider-controls-image<?=($key == 0 ? ' active' : '')?>"
								 data-entity="slider-control" data-value="<?=$photo['ID']?>" style="background-image: url('<?=$photo['SRC']?>');">
							</div>
						<?endforeach;?>
					<?endif;?>
				</div>
			<?endif;?>

			<div class="prod__meta-inf">
				<form id="addProductCartForm">
					<?if ($actualItem['CAN_BUY']):?>
						<input type="hidden" name="product_id" value="<?=$arResult['ID']?>" />
						<input type="hidden" name="vendor_code" value="<?=$arResult['DISPLAY_PROPERTIES']['VENDOR_CODE']['DISPLAY_VALUE']?>" />
						<input type="hidden" name="brand" value="<?=$arResult['DISPLAY_PROPERTIES']['BRAND']['DISPLAY_VALUE']?>" />
						<input type="hidden" name="composition" value="<?=$arResult['DISPLAY_PROPERTIES']['COMPOSITION']['DISPLAY_VALUE']?>" />
					<?endif;?>

					<?//PR($arParams);
//					if ($arParams['USE_VOTE_RATING'] === 'Y') {
//						$APPLICATION->IncludeComponent('bitrix:iblock.vote', 'main', array(
//							'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
//							'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
//							'IBLOCK_ID' => $arParams['IBLOCK_ID'],
//							'ELEMENT_ID' => $arResult['ID'],
//							'ELEMENT_CODE' => '',
//							'MAX_VOTE' => '5',
//							'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
//							'SET_STATUS_404' => 'N',
//							'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
//							'CACHE_TYPE' => $arParams['CACHE_TYPE'],
//							'CACHE_TIME' => $arParams['CACHE_TIME']
//						),
//							$component,
//							array('HIDE_ICONS' => 'Y')
//						);
//					}
					?>
					<?if (floatval($arResult["PROPERTIES"]["rating"]["VALUE"])):?>
						<div class="rating__stars stars<?=round($arResult["PROPERTIES"]["rating"]["VALUE"])?>"></div>
					<?else:?>
						<div class="rating__stars stars0"></div>
					<?endif;?>

					<?if ($arParams['DISPLAY_NAME'] === 'Y'):?>
						<h1 class="prod__title-prod">
							<?=strlen($arResult['DISPLAY_PROPERTIES']['BRAND']['DISPLAY_VALUE']) ? $arResult['DISPLAY_PROPERTIES']['BRAND']['DISPLAY_VALUE'].' | '.$name : $name?>
						</h1>
					<?endif;?>

					<div class="prod__big-price">
						<span class="price_alt" id="<?=$itemIds['PRICE_ID']?>"><?=$price['PRINT_RATIO_PRICE']?></span>
						<?if ($showDiscount):?>
							<span class="prix__old-prod" id="<?=$itemIds['OLD_PRICE_ID']?>"><?=$price['PRINT_RATIO_BASE_PRICE']?></span>
							<span class="prod__f__discount-amt" id="<?=$itemIds['DISCOUNT_PRICE_ID']?>">
							<?='-'.$price['PERCENT'].'%'?>
						</span>
						<?endif;?>
					</div>

					<?if (isset($arResult['DISPLAY_PROPERTIES']['VENDOR_CODE'])):?>
						<div class="prod__b-articolo">
							<?=$arResult['DISPLAY_PROPERTIES']['VENDOR_CODE']['NAME']?>: <?=$arResult['DISPLAY_PROPERTIES']['VENDOR_CODE']['DISPLAY_VALUE']?>
						</div>
					<?endif;?>

					<?if (isset($arResult['DISPLAY_PROPERTIES']['COMPOSITION'])):?>
						<div class="prod__b-contents">
							<?=$arResult['DISPLAY_PROPERTIES']['COMPOSITION']['NAME']?>: <?=$arResult['DISPLAY_PROPERTIES']['COMPOSITION']['DISPLAY_VALUE']?>
						</div>
					<?endif;?>

					<?if (isset($arResult['DISPLAY_PROPERTIES']['COLOR']) && is_array($arResult['DISPLAY_PROPERTIES']['COLOR']['VALUE'])):?>
						<div class="prod__b-color-chosen">
							<?=$arResult['DISPLAY_PROPERTIES']['COLOR']['NAME']?>: <span><?=is_array($arResult['DISPLAY_PROPERTIES']['COLOR']['DISPLAY_VALUE']) ?
								strtolower($arResult['DISPLAY_PROPERTIES']['COLOR']['DISPLAY_VALUE'][0]) : strtolower($arResult['DISPLAY_PROPERTIES']['COLOR']['DISPLAY_VALUE'])?></span>
						</div>

						<div class="prod__b-color-choose"><?=Loc::getMessage('SELECT_COLOR_TEXT')?>:</div>
						<div class="flex-row choose-colord">
							<?foreach ($arResult['DISPLAY_PROPERTIES']['COLOR']['VALUE'] as $key => $item):?>
                                <label style="display: inline-block;">
                                    <input type="radio"
                                           name="color"
                                           value="<?=$item?>"
                                           data-name="<?=is_array($arResult['DISPLAY_PROPERTIES']['COLOR']['DISPLAY_VALUE']) ?
                                               strtolower($arResult['DISPLAY_PROPERTIES']['COLOR']['DISPLAY_VALUE'][$key])
                                               : strtolower($arResult['DISPLAY_PROPERTIES']['COLOR']['DISPLAY_VALUE'])?>"
                                        <?=!$key ? 'checked' : ''?>
                                    />
                                    <div class="colord__prod" style="background-image: url('<?=$arResult['DISPLAY_PROPERTIES']['COLOR']['SRC'][$item]?>');"></div>
                                </label>
							<?endforeach;?>
						</div>
					<?endif;?>

					<?if (isset($arResult['DISPLAY_PROPERTIES']['SIZE']) && is_array($arResult['DISPLAY_PROPERTIES']['SIZE']['VALUE'])):?>
						<div class="prod__b-size-chosen">
							<?=$arResult['DISPLAY_PROPERTIES']['SIZE']['NAME']?>: <span><?=is_array($arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE']) ?
								$arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE'][0] : $arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE']?></span>
						</div>
						<div class="prod__b-choose-size"><?=Loc::getMessage('SELECT_SIZE_TEXT')?>:</div>
						<div class="flex-row choose-sized">
							<?foreach ($arResult['DISPLAY_PROPERTIES']['SIZE']['VALUE'] as $key => $item):?>
                                <label style="display: inline-block;">
                                    <input type="radio"
                                           name="size"
                                           value="<?=$item?>"
                                           data-name="<?=is_array($arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE']) ?
                                               $arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE'][$key]
                                               : $arResult['DISPLAY_PROPERTIES']['SIZE']['DISPLAY_VALUE']?>"
                                        <?=!$key ? 'checked' : ''?>
                                        />
                                    <div class="sized__prod s<?=$key?> <?=!$key ? 'chosn' : ''?>"><?=$arResult['DISPLAY_PROPERTIES']['SIZE']['VALUE'][$key]?></div>
                                </label>
                            <?endforeach;?>
						</div>
					<?endif;?>

					<div class="prod__b-choose-size">
						<?=Loc::getMessage('CT_BCE_QUANTITY')?>:
					</div>

					<?if ($actualItem['CAN_BUY']):?>
						<div class="flex-row choose-amt-prd">
							<a href="javascript:void(0);" class="minus" id="<?=$itemIds['QUANTITY_DOWN_ID']?>">-</a>
							<input name="quantity" value="<?=$price['MIN_QUANTITY']?>" min="1" step="1" type="number" id="<?=$itemIds['QUANTITY_ID']?>" class="in__prod-amt">
							<a href="javascript:void(0);" id="<?=$itemIds['QUANTITY_UP_ID']?>" class="plus">+</a>
						</div>

						<div class="product-item-detail-info-container">
							<input id="detailAdd2BasketButton" type="button" value="<?=$arParams['MESS_BTN_ADD_TO_BASKET']?>" />
						</div>
					<?endif;?>
				</form>
			</div>
		</div>

		<div class="flex-row lower-desc-prod">
			<div class="col__l1-prod">
				<div class="flex-row brand-sect">
					<div class="col__brnd im-vilermo-i" style="background-image: url('<?=$arResult['DISPLAY_PROPERTIES']['BRAND']['SRC']?>')"></div>
					<div class="flex-row socials__f">
						<a href="https://www.facebook.com/sharer/sharer.php" target="_blank" class="sociald sociald__fb"></a>
						<a href="https://www.instagram.com/?hl=ru" target="_blank" class="sociald sociald__ig"></a>
						<a href="https://vk.com/share.php?url=<?=$_SERVER["HTTP_REFERER"]?>" target="_blank" class="sociald sociald__vk"></a>
					</div>
				</div>
				<div class="block-expand">
					<div class="expand__header">Отзывы</div>
					<div class="expand__content">
						<?if ($arParams['USE_COMMENTS'] === 'Y'):?>
							<?$APPLICATION->IncludeComponent("altasib:review.list", "product_detail", Array(
								"ALLOW_VOTE" => "N",	// Разрешить голосование
								"AVATAR_HEIGHT" => "80",	// Высота аватара
								"AVATAR_WIDTH" => "80",	// Ширина аватара
								"CACHE_TIME" => "3600",	// Время кеширования (сек.)
								"CACHE_TYPE" => "A",	// Тип кеширования
								"CATALOG_IS_SEF" => "Y",	// Каталог работает в режиме ЧПУ
								"COMMENTS_MODE" => "Y",	// Режим комментариев
								"DETAIL_PAGE_URL" => "/catalog/#ELEMENT_CODE#/",	// Шаблон URL, ведущий на страницу с элементом
								"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
								"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
								"EMPTY_MESSAGE" => "Отзывы отсутствуют.",	// Текст который будет выведен при отсутствии отзывов
								"IBLOCK_ID" => IBLOCK_ID__CATALOG,	// Инфо-блок
								"IBLOCK_TYPE" => "catalog",	// Тип инфо-блока
								"LIST_TITLE" => "",	// Заголовок списка отзывов
								"MOD_GOUPS" => array(	// Группы модераторов
									0 => "1",
								),
								"NAME_SHOW_TYPE" => "NAME_LAST_NAME",	// Отображать имя в списке как:
								"ONLY_AUTH_COMPLAINT" => "Y",	// Только авторизованные пользователи могут пожаловаться на комментарий
								"POST_DATE_FORMAT" => "d.m.Y H:i:s",	// Формат даты
								"REVIEWS_ON_PAGE" => "15",	// Показывать отзывов за раз
								"SEF_BASE_URL" => "/catalog/",	// Каталог ЧПУ (относительно корня сайта)
								"SHOW_AVATAR_TYPE" => "user",	// Отображать аватар в списке отзывов из
								"SHOW_MAIN_RATING" => "Y",	// Позволять выставлять общую оценку
								"SHOW_UPLOAD_FILE" => "N",	// Разрешить отображение загруженных файлов
								"UF" => "",	// Отображать дополнительные поля
								"UF_VOTE" => "",	// Отображать оценки
								"USER_PATH" => PATH_TO_PERSONAL,	// Путь к профайлу пользователя
							),
								$component,
								array('HIDE_ICONS' => 'Y')
							);?>

							<?$APPLICATION->IncludeComponent("altasib:review.add", "product_detail", Array(
								"ADD_TITLE" => "",	// Текст ссылки добавления отзыва
								"ALLOW_TITLE" => "N",	// Разрешить вводить заголовок отзыва
								"ALLOW_UPLOAD_FILE" => "N",	// Разрешить загрузку файлов
								"CATALOG_IS_SEF" => "Y",	// Каталог работает в режиме ЧПУ
								"COMMENTS_MODE" => "Y",	// Режим комментариев
								"DETAIL_PAGE_URL" => "/catalog/#ELEMENT_CODE#/",	// Шаблон URL, ведущий на страницу с элементом
								"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
								"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
								"IBLOCK_ID" => "1",	// Инфо-блок
								"IBLOCK_TYPE" => "catalog",	// Тип инфо-блока
								"MAX_LENGTH" => "",	// Максимальная длина комментария
								"MESSAGE_OK" => "Отзыв добавлен.",	// Сообщение об успешном добавлении отзыва
								"MINUS_TEXT_MAX_LENGTH" => "",	// Максимальная длина поля Недостатки
								"MINUS_TEXT_MIN_LENGTH" => "",	// Минимальная длина поля Недостатки
								"MIN_LENGTH" => "5",	// Минимальная длина комментария
								"MODERATE" => "Y",	// Модерировать все отзывы
								"MODERATE_LINK" => "N",	// Отправлять на модерацию при наличии ссылки в тексте
								"MOD_GOUPS" => array(	// Группы модераторов
									0 => "1",
								),
								"NOT_HIDE_FORM" => "N",	// Не скрывать форму добавления отзыва
								"ONLY_AUTH_SEND" => "Y",	// Разрешить оставлять отзывы только авторизованным пользователям
								"PLUS_TEXT_MAX_LENGTH" => "",	// Максимальная длина поля Достоинства
								"PLUS_TEXT_MIN_LENGTH" => "5",	// Минимальная длина поля Достоинства
								"REG_URL" => PATH_TO_AUTH,	// Страница регистрации
								"SAVE_COUNT" => "Y",	// Сохранять количество отзывов в свойство ИБ
								"SAVE_COUNT_IB_PROPERTY" => "REVIEW_COUNT",	// Свойство ИБ для хранения количества отзывов
								"SAVE_RATING" => "Y",	// Сохранять рейтинг товара в свойство элемента
								"SAVE_RATING_IB_PROPERTY" => "RATING",	// Свойство ИБ для сохранения рейтинга
								"SEF_BASE_URL" => "/catalog/",	// Каталог ЧПУ (относительно корня сайта)
								"SEND_NOTIFY" => "N",	// Оправлять письмо с благодарностью за оставленный отзыв
								"SHOW_MAIN_RATING" => "Y",	// Позволять выставлять общую оценку
								"SHOW_POPUP" => "N",	// Показывать форму добавления отзыва во всплывающем окне
								"TITLE_MIN_LENGTH" => "5",	// Минимальная длина поля Заголовок отзыва
								"UF" => "",	// Отображать дополнительные поля
								"UF_VOTE" => "",	// Отображать оценки
								"UPLOAD_FILE_SIZE" => "150",	// Максимальный размер загружаемого файла (кб.)
								"UPLOAD_FILE_TYPE" => "jpg,jpeg,gif,png,ppt,doc,docx,xls,xlsx,odt,odp,ods,odb,rtf,txt",	// Типы загружаемых файлов (расширения через запятую)(если не заполнено, разрешены все типы)
								"USER_CONSENT" => "N",	// Запрашивать согласие
								"USER_CONSENT_ID" => "0",	// Соглашение
								"USER_CONSENT_IS_CHECKED" => "Y",	// Галка по умолчанию проставлена
								"USER_CONSENT_IS_LOADED" => "N",	// Загружать текст сразу
								"USE_CAPTCHA" => "Y",	// Использовать CAPTCHA для неавторизованных пользователей
							),
								$component,
								array('HIDE_ICONS' => 'Y')
							);?>

							<?/*
							$componentCommentsParams = array(
								'ELEMENT_ID' => $arResult['ID'],
								'ELEMENT_CODE' => '',
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
								'URL_TO_COMMENT' => '',
								'WIDTH' => '',
								'COMMENTS_COUNT' => '5',
								'BLOG_USE' => $arParams['BLOG_USE'],
								'FB_USE' => $arParams['FB_USE'],
								'FB_APP_ID' => $arParams['FB_APP_ID'],
								'VK_USE' => $arParams['VK_USE'],
								'VK_API_ID' => $arParams['VK_API_ID'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'BLOG_TITLE' => '',
								'BLOG_URL' => $arParams['BLOG_URL'],
								'PATH_TO_SMILE' => '',
								'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
								'AJAX_POST' => 'Y',
								'SHOW_SPAM' => 'Y',
								'SHOW_RATING' => 'N',
								'FB_TITLE' => '',
								'FB_USER_ADMIN_ID' => '',
								'FB_COLORSCHEME' => 'light',
								'FB_ORDER_BY' => 'reverse_time',
								'VK_TITLE' => '',
								'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
							);
							if(isset($arParams["USER_CONSENT"]))
								$componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
							if(isset($arParams["USER_CONSENT_ID"]))
								$componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
							if(isset($arParams["USER_CONSENT_IS_CHECKED"]))
								$componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
							if(isset($arParams["USER_CONSENT_IS_LOADED"]))
								$componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
							$APPLICATION->IncludeComponent('bitrix:catalog.comments', 'main', $componentCommentsParams, $component, array('HIDE_ICONS' => 'Y'));
							*/?>
						<?endif;?>
					</div>
				</div>
				<div class="block-expand">
					<div class="expand__header">Задать вопрос</div>
					<div class="expand__content">
						<?
						$APPLICATION->IncludeComponent("emotion:main.feedback", "product_detail", Array(
							"AJAX_MODE" => "N",  // режим AJAX
							"AJAX_OPTION_SHADOW" => "N", // затемнять область
							"AJAX_OPTION_JUMP" => "N", // скроллить страницу до компонента
							"AJAX_OPTION_STYLE" => "Y", // подключать стили
							"AJAX_OPTION_HISTORY" => "N",
							"EMAIL_TO" => "",	// E-mail, на который будет отправлено письмо
							"EVENT_MESSAGE_ID" => array(85),	// Почтовые шаблоны для отправки письма
							"OK_TEXT" => "Спасибо, ваше сообщение принято.",	// Сообщение, выводимое пользователю после отправки
							"REQUIRED_FIELDS" => array(	// Обязательные поля для заполнения
								0 => "NAME",
								1 => "PHONE",
								2 => "EMAIL",
							),
							"USE_CAPTCHA" => "N",	// Использовать защиту от автоматических сообщений (CAPTCHA) для неавторизованных пользователей
						),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
				</div>
			</div>

			<div class="col__r1-rod">
				<div class="block-expand">
					<div class="expand__header">Описание</div>
					<div class="expand__content">
						<?if ($showDescription):?>
							<?
							if ($arResult['PREVIEW_TEXT'] != '' && ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S' || ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == ''))) {
								echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>';
							}

							if ($arResult['DETAIL_TEXT'] != '') {
								echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>';
							}
							?>
						<?endif;?>
					</div>
				</div>

				<div class="block-expand">
					<div class="expand__header">Параметры</div>
					<div class="expand__content">
						<?if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']):?>
							<?if (!empty($arResult['DISPLAY_PROPERTIES'])):?>
								<dl class="product-item-detail-properties">
									<?foreach ($arResult['DISPLAY_PROPERTIES'] as $property):?>
										<dt><?=$property['NAME']?></dt>
										<dd><?=(
											is_array($property['DISPLAY_VALUE'])
												? implode(' / ', $property['DISPLAY_VALUE'])
												: $property['DISPLAY_VALUE']
											)?>
										</dd>
									<?endforeach;?>
									<?unset($property);?>
								</dl>
							<?endif;?>
						<?endif;?>
					</div>
				</div>

				<div class="block-expand">
					<div class="expand__header">Доставка</div>
					<div class="expand__content">
						<?
//                        PR($arResult["DELIVERY_METHODS"]);
                        foreach ($arResult["DELIVERY_METHODS"] as $dm) {
                            echo "<div class=\"list-item\">{$dm['NAME']}</div>";
                        }
                        ?>
					</div>
				</div>

				<div class="block-expand">
					<div class="expand__header">Оплата</div>
					<div class="expand__content">
                        <?
                        //                        PR($arResult["PAY_SYSTEMS"]);
                        foreach ($arResult["PAY_SYSTEMS"] as $ps) {
                            echo "<div class=\"list-item\">{$ps['NAME']}</div>";
                        }
                        ?>
					</div>
				</div>

				<div class="flex-row product__buttons-sect">
					<a href="<?=PATH_TO_BASKET?>" class="got-cart">Перейти в корзину</a>
					<a href="<?=PATH_TO_CATALOG?>" class="c-shopng">Продолжить покупки</a>
				</div>
			</div>
		</div>

		<?/*<div class="col-sm-6">
				<div class="product-item-detail-pay-block">
					<?
					foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName)
					{
						switch ($blockName)
						{
							case 'rating':
								if ($arParams['USE_VOTE_RATING'] === 'Y')
								{
									?>
									<div class="product-item-detail-info-container">
										<?
										$APPLICATION->IncludeComponent(
											'bitrix:iblock.vote',
											'stars',
											array(
												'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
												'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
												'IBLOCK_ID' => $arParams['IBLOCK_ID'],
												'ELEMENT_ID' => $arResult['ID'],
												'ELEMENT_CODE' => '',
												'MAX_VOTE' => '5',
												'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
												'SET_STATUS_404' => 'N',
												'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
												'CACHE_TYPE' => $arParams['CACHE_TYPE'],
												'CACHE_TIME' => $arParams['CACHE_TIME']
											),
											$component,
											array('HIDE_ICONS' => 'Y')
										);
										?>
									</div>
								<?
								}

								break;

							case 'price':
								?>
								<div class="product-item-detail-info-container">
									<?
									if ($arParams['SHOW_OLD_PRICE'] === 'Y')
									{
										?>
										<div class="product-item-detail-price-old" id="<?=$itemIds['OLD_PRICE_ID']?>"
											 style="display: <?=($showDiscount ? '' : 'none')?>;">
											<?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
										</div>
									<?
									}
									?>
									<div class="product-item-detail-price-current" id="<?=$itemIds['PRICE_ID']?>">
										<?=$price['PRINT_RATIO_PRICE']?>
									</div>
									<?
									if ($arParams['SHOW_OLD_PRICE'] === 'Y')
									{
										?>
										<div class="item_economy_price" id="<?=$itemIds['DISCOUNT_PRICE_ID']?>"
											 style="display: <?=($showDiscount ? '' : 'none')?>;">
											<?
											if ($showDiscount)
											{
												echo Loc::getMessage('CT_BCE_CATALOG_ECONOMY_INFO2', array('#ECONOMY#' => $price['PRINT_RATIO_DISCOUNT']));
											}
											?>
										</div>
									<?
									}
									?>
								</div>
								<?
								break;

							case 'priceRanges':
								if ($arParams['USE_PRICE_COUNT'])
								{
									$showRanges = !$haveOffers && count($actualItem['ITEM_QUANTITY_RANGES']) > 1;
									$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';
									?>
									<div class="product-item-detail-info-container"
										<?=$showRanges ? '' : 'style="display: none;"'?>
										 data-entity="price-ranges-block">
										<div class="product-item-detail-info-container-title">
											<?=$arParams['MESS_PRICE_RANGES_TITLE']?>
											<span data-entity="price-ranges-ratio-header">
														(<?=(Loc::getMessage(
													'CT_BCE_CATALOG_RATIO_PRICE',
													array('#RATIO#' => ($useRatio ? $measureRatio : '1').' '.$actualItem['ITEM_MEASURE']['TITLE'])
												))?>)
													</span>
										</div>
										<dl class="product-item-detail-properties" data-entity="price-ranges-body">
											<?
											if ($showRanges)
											{
												foreach ($actualItem['ITEM_QUANTITY_RANGES'] as $range)
												{
													if ($range['HASH'] !== 'ZERO-INF')
													{
														$itemPrice = false;

														foreach ($arResult['ITEM_PRICES'] as $itemPrice)
														{
															if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
															{
																break;
															}
														}

														if ($itemPrice)
														{
															?>
															<dt>
																<?
																echo Loc::getMessage(
																		'CT_BCE_CATALOG_RANGE_FROM',
																		array('#FROM#' => $range['SORT_FROM'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
																	).' ';

																if (is_infinite($range['SORT_TO']))
																{
																	echo Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
																}
																else
																{
																	echo Loc::getMessage(
																		'CT_BCE_CATALOG_RANGE_TO',
																		array('#TO#' => $range['SORT_TO'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
																	);
																}
																?>
															</dt>
															<dd><?=($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE'])?></dd>
														<?
														}
													}
												}
											}
											?>
										</dl>
									</div>
									<?
									unset($showRanges, $useRatio, $itemPrice, $range);
								}

								break;

							case 'quantityLimit':
								if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
								{
									if ($haveOffers)
									{
										?>
										<div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>" style="display: none;">
											<div class="product-item-detail-info-container-title">
												<?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
												<span class="product-item-quantity" data-entity="quantity-limit-value"></span>
											</div>
										</div>
									<?
									}
									else
									{
										if (
											$measureRatio
											&& (float)$actualItem['CATALOG_QUANTITY'] > 0
											&& $actualItem['CATALOG_QUANTITY_TRACE'] === 'Y'
											&& $actualItem['CATALOG_CAN_BUY_ZERO'] === 'N'
										)
										{
											?>
											<div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
												<div class="product-item-detail-info-container-title">
													<?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
															<span class="product-item-quantity" data-entity="quantity-limit-value">
																<?
																if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
																{
																	if ((float)$actualItem['CATALOG_QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
																	{
																		echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
																	}
																	else
																	{
																		echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
																	}
																}
																else
																{
																	echo $actualItem['CATALOG_QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
																}
																?>
															</span>
												</div>
											</div>
										<?
										}
									}
								}

								break;

							case 'quantity':
								if ($arParams['USE_PRODUCT_QUANTITY'])
								{
									?>
									<div class="product-item-detail-info-container" style="<?=(!$actualItem['CAN_BUY'] ? 'display: none;' : '')?>"
										 data-entity="quantity-block">
										<div class="product-item-detail-info-container-title"><?=Loc::getMessage('CATALOG_QUANTITY')?></div>
										<div class="product-item-amount">
											<div class="product-item-amount-field-container">
												<span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN_ID']?>"></span>
												<input class="product-item-amount-field" id="<?=$itemIds['QUANTITY_ID']?>" type="number"
													   value="<?=$price['MIN_QUANTITY']?>">
												<span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP_ID']?>"></span>
														<span class="product-item-amount-description-container">
															<span id="<?=$itemIds['QUANTITY_MEASURE']?>">
																<?=$actualItem['ITEM_MEASURE']['TITLE']?>
															</span>
															<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
														</span>
											</div>
										</div>
									</div>
								<?
								}

								break;

							case 'buttons':
								?>
								<div data-entity="main-button-container">
									<div id="<?=$itemIds['BASKET_ACTIONS_ID']?>" style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">
										<?
										if ($showAddBtn)
										{
											?>
											<div class="product-item-detail-info-container">
												<a class="btn <?=$showButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['ADD_BASKET_LINK']?>"
												   href="javascript:void(0);">
													<span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span>
												</a>
											</div>
										<?
										}

										if ($showBuyBtn)
										{
											?>
											<div class="product-item-detail-info-container">
												<a class="btn <?=$buyButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['BUY_LINK']?>"
												   href="javascript:void(0);">
													<span><?=$arParams['MESS_BTN_BUY']?></span>
												</a>
											</div>
										<?
										}
										?>
									</div>
									<?
									if ($showSubscribe)
									{
										?>
										<div class="product-item-detail-info-container">
											<?
											$APPLICATION->IncludeComponent(
												'bitrix:catalog.product.subscribe',
												'',
												array(
													'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
													'PRODUCT_ID' => $arResult['ID'],
													'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
													'BUTTON_CLASS' => 'btn btn-default product-item-detail-buy-button',
													'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
													'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
												),
												$component,
												array('HIDE_ICONS' => 'Y')
											);
											?>
										</div>
									<?
									}
									?>
									<div class="product-item-detail-info-container">
										<a class="btn btn-link product-item-detail-buy-button" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>"
										   href="javascript:void(0)"
										   rel="nofollow" style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;">
											<?=$arParams['MESS_NOT_AVAILABLE']?>
										</a>
									</div>
								</div>
								<?
								break;
						}
					}

					if ($arParams['DISPLAY_COMPARE'])
					{
						?>
						<div class="product-item-detail-compare-container">
							<div class="product-item-detail-compare">
								<div class="checkbox">
									<label id="<?=$itemIds['COMPARE_LINK']?>">
										<input type="checkbox" data-entity="compare-checkbox">
										<span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
									</label>
								</div>
							</div>
						</div>
					<?
					}
					?>
				</div>
			</div>*/?>

		<?if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP']):?>
			<div class="row">
				<div class="col-xs-12">
					<?$APPLICATION->IncludeComponent(
						'bitrix:catalog.set.constructor',
						'.default',
						array(
							'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
							'IBLOCK_ID' => $arParams['IBLOCK_ID'],
							'ELEMENT_ID' => $arResult['ID'],
							'PRICE_CODE' => $arParams['PRICE_CODE'],
							'BASKET_URL' => $arParams['BASKET_URL'],
							'CACHE_TYPE' => $arParams['CACHE_TYPE'],
							'CACHE_TIME' => $arParams['CACHE_TIME'],
							'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
							'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'CURRENCY_ID' => $arParams['CURRENCY_ID']
						),
						$component,
						array('HIDE_ICONS' => 'Y')
					);?>
				</div>
			</div>
		<?endif;?>

		<?/*<div class="row">
			<div class="col-sm-8 col-md-9">
				<div class="row" id="<?=$itemIds['TABS_ID']?>">
					<div class="col-xs-12">
						<div class="product-item-detail-tabs-container">
							<ul class="product-item-detail-tabs-list">
								<?
								if ($showDescription)
								{
									?>
									<li class="product-item-detail-tab active" data-entity="tab" data-value="description">
										<a href="javascript:void(0);" class="product-item-detail-tab-link">
											<span><?=$arParams['MESS_DESCRIPTION_TAB']?></span>
										</a>
									</li>
									<?
								}

								if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
								{
									?>
									<li class="product-item-detail-tab" data-entity="tab" data-value="properties">
										<a href="javascript:void(0);" class="product-item-detail-tab-link">
											<span><?=$arParams['MESS_PROPERTIES_TAB']?></span>
										</a>
									</li>
									<?
								}

								if ($arParams['USE_COMMENTS'] === 'Y')
								{
									?>
									<li class="product-item-detail-tab" data-entity="tab" data-value="comments">
										<a href="javascript:void(0);" class="product-item-detail-tab-link">
											<span><?=$arParams['MESS_COMMENTS_TAB']?></span>
										</a>
									</li>
									<?
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="row" id="<?=$itemIds['TAB_CONTAINERS_ID']?>">
					<div class="col-xs-12">
						<?
						if ($showDescription)
						{
							?>
							<div class="product-item-detail-tab-content active" data-entity="tab-container" data-value="description"
								itemprop="description">
								<?
								if (
									$arResult['PREVIEW_TEXT'] != ''
									&& (
										$arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
										|| ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
									)
								)
								{
									echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>';
								}

								if ($arResult['DETAIL_TEXT'] != '')
								{
									echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>';
								}
								?>
							</div>
							<?
						}

						if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
						{
							?>
							<div class="product-item-detail-tab-content" data-entity="tab-container" data-value="properties">
								<?
								if (!empty($arResult['DISPLAY_PROPERTIES']))
								{
									?>
									<dl class="product-item-detail-properties">
										<?
										foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
										{
											?>
											<dt><?=$property['NAME']?></dt>
											<dd><?=(
												is_array($property['DISPLAY_VALUE'])
													? implode(' / ', $property['DISPLAY_VALUE'])
													: $property['DISPLAY_VALUE']
												)?>
											</dd>
											<?
										}
										unset($property);
										?>
									</dl>
									<?
								}

								if ($arResult['SHOW_OFFERS_PROPS'])
								{
									?>
									<dl class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_PROP_DIV']?>"></dl>
									<?
								}
								?>
							</div>
							<?
						}

						if ($arParams['USE_COMMENTS'] === 'Y')
						{
							?>
							<div class="product-item-detail-tab-content" data-entity="tab-container" data-value="comments" style="display: none;">
								<?
								$componentCommentsParams = array(
									'ELEMENT_ID' => $arResult['ID'],
									'ELEMENT_CODE' => '',
									'IBLOCK_ID' => $arParams['IBLOCK_ID'],
									'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
									'URL_TO_COMMENT' => '',
									'WIDTH' => '',
									'COMMENTS_COUNT' => '5',
									'BLOG_USE' => $arParams['BLOG_USE'],
									'FB_USE' => $arParams['FB_USE'],
									'FB_APP_ID' => $arParams['FB_APP_ID'],
									'VK_USE' => $arParams['VK_USE'],
									'VK_API_ID' => $arParams['VK_API_ID'],
									'CACHE_TYPE' => $arParams['CACHE_TYPE'],
									'CACHE_TIME' => $arParams['CACHE_TIME'],
									'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
									'BLOG_TITLE' => '',
									'BLOG_URL' => $arParams['BLOG_URL'],
									'PATH_TO_SMILE' => '',
									'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
									'AJAX_POST' => 'Y',
									'SHOW_SPAM' => 'Y',
									'SHOW_RATING' => 'N',
									'FB_TITLE' => '',
									'FB_USER_ADMIN_ID' => '',
									'FB_COLORSCHEME' => 'light',
									'FB_ORDER_BY' => 'reverse_time',
									'VK_TITLE' => '',
									'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME']
								);
								if(isset($arParams["USER_CONSENT"]))
									$componentCommentsParams["USER_CONSENT"] = $arParams["USER_CONSENT"];
								if(isset($arParams["USER_CONSENT_ID"]))
									$componentCommentsParams["USER_CONSENT_ID"] = $arParams["USER_CONSENT_ID"];
								if(isset($arParams["USER_CONSENT_IS_CHECKED"]))
									$componentCommentsParams["USER_CONSENT_IS_CHECKED"] = $arParams["USER_CONSENT_IS_CHECKED"];
								if(isset($arParams["USER_CONSENT_IS_LOADED"]))
									$componentCommentsParams["USER_CONSENT_IS_LOADED"] = $arParams["USER_CONSENT_IS_LOADED"];
								$APPLICATION->IncludeComponent(
									'bitrix:catalog.comments',
									'',
									$componentCommentsParams,
									$component,
									array('HIDE_ICONS' => 'Y')
								);
								?>
							</div>
							<?
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-md-3">
				<div>
					<?
					if ($arParams['BRAND_USE'] === 'Y')
					{
						$APPLICATION->IncludeComponent(
							'bitrix:catalog.brandblock',
							'.default',
							array(
								'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'ELEMENT_ID' => $arResult['ID'],
								'ELEMENT_CODE' => '',
								'PROP_CODE' => $arParams['BRAND_PROP_CODE'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'WIDTH' => '',
								'HEIGHT' => ''
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
					}
					?>
				</div>
			</div>
		</div>*/?>

		<?/*<div class="row">
			<div class="col-xs-12">
				<?
				if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					$APPLICATION->IncludeComponent(
						'bitrix:sale.prediction.product.detail',
						'.default',
						array(
							'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
							'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
							'POTENTIAL_PRODUCT_TO_BUY' => array(
								'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
								'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
								'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
								'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
								'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

								'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
								'SECTION' => array(
									'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
									'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
									'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
									'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
								),
							)
						),
						$component,
						array('HIDE_ICONS' => 'Y')
					);
				}

				if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					?>
					<div data-entity="parent-container">
						<?
						if (!isset($arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
						{
							?>
							<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
								<?=($arParams['GIFTS_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFT_BLOCK_TITLE_DEFAULT'))?>
							</div>
							<?
						}

						CBitrixComponent::includeComponentClass('bitrix:sale.products.gift');
						$APPLICATION->IncludeComponent(
							'bitrix:sale.products.gift',
							'.default',
							array(
								'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
								'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
								'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],

								'PRODUCT_ROW_VARIANTS' => "",
								'PAGE_ELEMENT_COUNT' => 0,
								'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
									SaleProductsGiftComponent::predictRowVariants(
										$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
										$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']
									)
								),
								'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],

								'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
								'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
								'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
								'PRODUCT_DISPLAY_MODE' => 'Y',
								'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],
								'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
								'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
								'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

								'TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],

								'LABEL_PROP_'.$arParams['IBLOCK_ID'] => array(),
								'LABEL_PROP_MOBILE_'.$arParams['IBLOCK_ID'] => array(),
								'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

								'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
								'MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
								'MESS_BTN_ADD_TO_BASKET' => $arParams['~GIFTS_MESS_BTN_BUY'],
								'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
								'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],

								'SHOW_PRODUCTS_'.$arParams['IBLOCK_ID'] => 'Y',
								'PROPERTY_CODE_'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE'],
								'PROPERTY_CODE_MOBILE'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE_MOBILE'],
								'PROPERTY_CODE_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
								'OFFER_TREE_PROPS_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
								'CART_PROPERTIES_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFERS_CART_PROPERTIES'],
								'ADDITIONAL_PICT_PROP_'.$arParams['IBLOCK_ID'] => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
								'ADDITIONAL_PICT_PROP_'.$arResult['OFFERS_IBLOCK'] => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),

								'HIDE_NOT_AVAILABLE' => 'Y',
								'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
								'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
								'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
								'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
								'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
								'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
								'USE_PRODUCT_QUANTITY' => 'N',
								'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'POTENTIAL_PRODUCT_TO_BUY' => array(
									'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
									'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
									'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
									'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
									'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

									'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
										? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID']
										: null,
									'SECTION' => array(
										'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
										'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
										'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
										'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
									),
								),

								'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
								'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
								'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
					<?
				}

				if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					?>
					<div data-entity="parent-container">
						<?
						if (!isset($arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
						{
							?>
							<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
								<?=($arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFTS_MAIN_BLOCK_TITLE_DEFAULT'))?>
							</div>
							<?
						}

						$APPLICATION->IncludeComponent(
							'bitrix:sale.gift.main.products',
							'.default',
							array(
								'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
								'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
								'LINE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
								'HIDE_BLOCK_TITLE' => 'Y',
								'BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

								'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
								'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],

								'AJAX_MODE' => $arParams['AJAX_MODE'],
								'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],

								'ELEMENT_SORT_FIELD' => 'ID',
								'ELEMENT_SORT_ORDER' => 'DESC',
								//'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
								//'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
								'FILTER_NAME' => 'searchFilter',
								'SECTION_URL' => $arParams['SECTION_URL'],
								'DETAIL_URL' => $arParams['DETAIL_URL'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
								'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
								'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],

								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],

								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'SET_TITLE' => $arParams['SET_TITLE'],
								'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
								'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

								'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID'],
								'HIDE_NOT_AVAILABLE' => 'Y',
								'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
								'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
								'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],

								'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
								'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
								'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

								'ADD_PICT_PROP' => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
								'LABEL_PROP' => (isset($arParams['LABEL_PROP']) ? $arParams['LABEL_PROP'] : ''),
								'LABEL_PROP_MOBILE' => (isset($arParams['LABEL_PROP_MOBILE']) ? $arParams['LABEL_PROP_MOBILE'] : ''),
								'LABEL_PROP_POSITION' => (isset($arParams['LABEL_PROP_POSITION']) ? $arParams['LABEL_PROP_POSITION'] : ''),
								'OFFER_ADD_PICT_PROP' => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),
								'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : ''),
								'SHOW_DISCOUNT_PERCENT' => (isset($arParams['SHOW_DISCOUNT_PERCENT']) ? $arParams['SHOW_DISCOUNT_PERCENT'] : ''),
								'DISCOUNT_PERCENT_POSITION' => (isset($arParams['DISCOUNT_PERCENT_POSITION']) ? $arParams['DISCOUNT_PERCENT_POSITION'] : ''),
								'SHOW_OLD_PRICE' => (isset($arParams['SHOW_OLD_PRICE']) ? $arParams['SHOW_OLD_PRICE'] : ''),
								'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
								'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
								'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
								'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
								'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
								'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
								'DISPLAY_COMPARE' => (isset($arParams['DISPLAY_COMPARE']) ? $arParams['DISPLAY_COMPARE'] : ''),
								'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
							)
							+ array(
								'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
									? $arResult['ID']
									: $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
								'SECTION_ID' => $arResult['SECTION']['ID'],
								'ELEMENT_ID' => $arResult['ID'],

								'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
								'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
								'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
					<?
				}
				?>
			</div>
		</div>*/?>
	</div>

	<!--Small Card-->
	<div class="product-item-detail-short-card-fixed hidden-xs" id="<?=$itemIds['SMALL_CARD_PANEL_ID']?>" style="display: none;">
		<div class="product-item-detail-short-card-content-container">
			<table>
				<tr>
					<td rowspan="2" class="product-item-detail-short-card-image">
						<img src="" style="height: 65px;" data-entity="panel-picture">
					</td>
					<td class="product-item-detail-short-title-container" data-entity="panel-title">
						<span class="product-item-detail-short-title-text"><?=$name?></span>
					</td>
					<td rowspan="2" class="product-item-detail-short-card-price">
						<?
						if ($arParams['SHOW_OLD_PRICE'] === 'Y')
						{
							?>
							<div class="product-item-detail-price-old" style="display: <?=($showDiscount ? '' : 'none')?>;"
								 data-entity="panel-old-price">
								<?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
							</div>
						<?
						}
						?>
						<div class="product-item-detail-price-current" data-entity="panel-price">
							<?=$price['PRINT_RATIO_PRICE']?>
						</div>
					</td>
					<?
					if ($showAddBtn)
					{
						?>
						<td rowspan="2" class="product-item-detail-short-card-btn"
							style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;"
							data-entity="panel-add-button">
							<a class="btn <?=$showButtonClassName?> product-item-detail-buy-button"
							   id="<?=$itemIds['ADD_BASKET_LINK']?>"
							   href="javascript:void(0);">
								<span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span>
							</a>
						</td>
					<?
					}

					if ($showBuyBtn)
					{
						?>
						<td rowspan="2" class="product-item-detail-short-card-btn"
							style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;"
							data-entity="panel-buy-button">
							<a class="btn <?=$buyButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['BUY_LINK']?>"
							   href="javascript:void(0);">
								<span><?=$arParams['MESS_BTN_BUY']?></span>
							</a>
						</td>
					<?
					}
					?>
					<td rowspan="2" class="product-item-detail-short-card-btn"
						style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;"
						data-entity="panel-not-available-button">
						<a class="btn btn-link product-item-detail-buy-button" href="javascript:void(0)"
						   rel="nofollow">
							<?=$arParams['MESS_NOT_AVAILABLE']?>
						</a>
					</td>
				</tr>
				<?
				if ($haveOffers)
				{
					?>
					<tr>
						<td>
							<div class="product-item-selected-scu-container" data-entity="panel-sku-container">
								<?
								$i = 0;

								foreach ($arResult['SKU_PROPS'] as $skuProperty)
								{
									if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
									{
										continue;
									}

									$propertyId = $skuProperty['ID'];

									foreach ($skuProperty['VALUES'] as $value)
									{
										$value['NAME'] = htmlspecialcharsbx($value['NAME']);
										if ($skuProperty['SHOW_MODE'] === 'PICT')
										{
											?>
											<div class="product-item-selected-scu product-item-selected-scu-color selected"
												 title="<?=$value['NAME']?>"
												 style="background-image: url('<?=$value['PICT']['SRC']?>'); display: none;"
												 data-sku-line="<?=$i?>"
												 data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
												 data-onevalue="<?=$value['ID']?>">
											</div>
										<?
										}
										else
										{
											?>
											<div class="product-item-selected-scu product-item-selected-scu-text selected"
												 title="<?=$value['NAME']?>"
												 style="display: none;"
												 data-sku-line="<?=$i?>"
												 data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
												 data-onevalue="<?=$value['ID']?>">
												<?=$value['NAME']?>
											</div>
										<?
										}
									}

									$i++;
								}
								?>
							</div>
						</td>
					</tr>
				<?
				}
				?>
			</table>
		</div>
	</div>

	<!--Top tabs-->
	<div class="product-item-detail-tabs-container-fixed hidden-xs" id="<?=$itemIds['TABS_PANEL_ID']?>" style="display: none;">
		<ul class="product-item-detail-tabs-list">
			<?
			if ($showDescription)
			{
				?>
				<li class="product-item-detail-tab active" data-entity="tab" data-value="description">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_DESCRIPTION_TAB']?></span>
					</a>
				</li>
			<?
			}

			if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
			{
				?>
				<li class="product-item-detail-tab" data-entity="tab" data-value="properties">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_PROPERTIES_TAB']?></span>
					</a>
				</li>
			<?
			}

			if ($arParams['USE_COMMENTS'] === 'Y')
			{
				?>
				<li class="product-item-detail-tab" data-entity="tab" data-value="comments">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_COMMENTS_TAB']?></span>
					</a>
				</li>
			<?
			}
			?>
		</ul>
	</div>

	<meta itemprop="name" content="<?=$name?>" />
	<meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
<?
if ($haveOffers)
{
	foreach ($arResult['JS_OFFERS'] as $offer)
	{
		$currentOffersList = array();

		if (!empty($offer['TREE']) && is_array($offer['TREE']))
		{
			foreach ($offer['TREE'] as $propName => $skuId)
			{
				$propId = (int)substr($propName, 5);

				foreach ($skuProps as $prop)
				{
					if ($prop['ID'] == $propId)
					{
						foreach ($prop['VALUES'] as $propId => $propValue)
						{
							if ($propId == $skuId)
							{
								$currentOffersList[] = $propValue['NAME'];
								break;
							}
						}
					}
				}
			}
		}

		$offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
		?>
		<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
				<meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
				<meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
				<link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
			</span>
	<?
	}

	unset($offerPrice, $currentOffersList);
}
else
{
	?>
	<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
			<meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
			<link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
		</span>
<?
}
?>

<?
if ($haveOffers)
{
	$offerIds = array();
	$offerCodes = array();

	$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

	foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
	{
		$offerIds[] = (int)$jsOffer['ID'];
		$offerCodes[] = $jsOffer['CODE'];

		$fullOffer = $arResult['OFFERS'][$ind];
		$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

		$strAllProps = '';
		$strMainProps = '';
		$strPriceRangesRatio = '';
		$strPriceRanges = '';

		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($jsOffer['DISPLAY_PROPERTIES']))
			{
				foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
				{
					$current = '<dt>'.$property['NAME'].'</dt><dd>'.(
						is_array($property['VALUE'])
							? implode(' / ', $property['VALUE'])
							: $property['VALUE']
						).'</dd>';
					$strAllProps .= $current;

					if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
					{
						$strMainProps .= $current;
					}
				}

				unset($current);
			}
		}

		if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
		{
			$strPriceRangesRatio = '('.Loc::getMessage(
					'CT_BCE_CATALOG_RATIO_PRICE',
					array('#RATIO#' => ($useRatio
							? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
							: '1'
						).' '.$measureName)
				).')';

			foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
			{
				if ($range['HASH'] !== 'ZERO-INF')
				{
					$itemPrice = false;

					foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
					{
						if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
						{
							break;
						}
					}

					if ($itemPrice)
					{
						$strPriceRanges .= '<dt>'.Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_FROM',
								array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
							).' ';

						if (is_infinite($range['SORT_TO']))
						{
							$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
						}
						else
						{
							$strPriceRanges .= Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_TO',
								array('#TO#' => $range['SORT_TO'].' '.$measureName)
							);
						}

						$strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
					}
				}
			}

			unset($range, $itemPrice);
		}

		$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
		$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
		$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
		$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
	}

	$templateData['OFFER_IDS'] = $offerIds;
	$templateData['OFFER_CODES'] = $offerCodes;
	unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => $itemIds,
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'NAME' => $arResult['~NAME'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps
	);
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties) {?>
		<div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
			<?if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo) {?>
					<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
					<?unset($arResult['PRODUCT_PROPERTIES'][$propId]);
				}
			}

			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties) {?>
				<table>
					<?foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo) {?>
						<tr>
							<td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
							<td>
								<?
								if (
									$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
									&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C') {
									foreach ($propInfo['VALUES'] as $valueId => $value) {
										?>
										<label>
											<input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
												   value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
											<?=$value?>
										</label>
										<br>
									<?
									}
								} else {?>
									<select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
										<?foreach ($propInfo['VALUES'] as $valueId => $value) {?>
											<option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
												<?=$value?>
											</option>
										<?}?>
									</select>
								<?}?>
							</td>
						</tr>
					<?}?>
				</table>
			<?}?>
		</div>
	<?
	}

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'VISUAL' => $itemIds,
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'PICT' => reset($arResult['MORE_PHOTO']),
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
			'ITEM_PRICES' => $arResult['ITEM_PRICES'],
			'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
			'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
			'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
			'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
			'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE'])
{
	$jsParams['COMPARE'] = array(
		'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
		'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
		'COMPARE_PATH' => $arParams['COMPARE_PATH']
	);
}
?>
	<script>
		BX.message({
			ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
			TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
			TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
			BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
			BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
			BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
			BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
			BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
			TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
			COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
			COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
			COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
			BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
			PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
			PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
			RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
			RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
			SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
		});

		var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
	</script>
<?
//PR($arResult);
unset($actualItem, $itemIds, $jsParams);