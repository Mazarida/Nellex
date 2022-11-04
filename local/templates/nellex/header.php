<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$dir = $APPLICATION->GetCurDir();
$page = $APPLICATION->GetCurPage();
//$show_left_sidebar = $APPLICATION->GetDirProperty("show_left_sidebar");
$assets = \Bitrix\Main\Page\Asset::getInstance();
?>

<!doctype html>
<html lang="<?=LANGUAGE_ID?>">
<head>
	<meta charset="<?=SITE_CHARSET?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?$APPLICATION->ShowTitle();?></title>

	<?
	/**
	 * CSS
	 */
	$assets->addCss(SITE_TEMPLATE_PATH.'/lib/swiper.min.css');
	$assets->addCss(SITE_TEMPLATE_PATH.'/style.vw.css');
	$assets->addCss(SITE_TEMPLATE_PATH.'/style_mob.vw.css');

	/**
	 * JS
	 */
	$assets->addJs(SITE_TEMPLATE_PATH."/lib/jquery-3.3.1.min.js");
	$assets->addJs(SITE_TEMPLATE_PATH."/lib/swiper.min.js");
	$assets->addJs(SITE_TEMPLATE_PATH."/lib/jquery.cookie.js");
	$assets->addJs(SITE_TEMPLATE_PATH."/main.js");

	/**
	 * FAVICON
	 */

//	$assets->addString('<link href="'.SITE_TEMPLATE_PATH.'/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />');

	/**
	 * BITRIX->ShowHead()
	 */
	$APPLICATION->ShowMeta("robots", false);
	$APPLICATION->ShowMeta("keywords", false);
	$APPLICATION->ShowMeta("description", false);
	$APPLICATION->ShowLink("canonical", null);
	$APPLICATION->ShowCSS(true);
	$APPLICATION->ShowHeadStrings();
	$APPLICATION->ShowHeadScripts();
	?>
    <link rel="stylesheet" href="/local/templates/nellex/styles_new.css?v=<?=time()?>">
    <link rel="stylesheet" href="/local/templates/nellex/styles_new_mob.css?v=<?=time()?>">
</head>

<body>

<?$APPLICATION->ShowPanel();?>

<div class="header__section">
	<div class="flex-row">
		<a href="<?=SITE_DIR?>" class="header__logo"></a>
		<? // Главное верхнее меню в шапке
		$APPLICATION->IncludeComponent("bitrix:menu", "header_menu", Array(
			"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
			"CHILD_MENU_TYPE" => "top",	// Тип меню для остальных уровней
			"DELAY" => "N",	// Откладывать выполнение шаблона меню
			"MAX_LEVEL" => "1",	// Уровень вложенности меню
			"MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
				0 => "",
			),
			"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
			"MENU_CACHE_TYPE" => "N",	// Тип кеширования
			"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
			"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
			"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		),
			false
		);
		?>
		<div class="flex-row header__lk-cart">
			<a href="<?=$USER->IsAuthorized() ? PATH_TO_PERSONAL : PATH_TO_AUTH?>" class="header__lk"></a>
			<?$wish_list = isset($_COOKIE['wishlist']) && !empty($_COOKIE['wishlist']) ? explode(',', $_COOKIE['wishlist']) : array();?>
			<a href="<?=PATH_TO_FAVORITE?>" class="header__like"></a>
			<div class="num-like"><?=count($wish_list)?></div>
			<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "main", Array(
				"HIDE_ON_BASKET_PAGES" => "N",	// Не показывать на страницах корзины и оформления заказа
				"PATH_TO_AUTHORIZE" => "",	// Страница авторизации
				"PATH_TO_BASKET" => PATH_TO_BASKET,	// Страница корзины
				"PATH_TO_ORDER" => PATH_TO_ORDER_MAKE,	// Страница оформления заказа
				"PATH_TO_PERSONAL" => PATH_TO_PERSONAL,	// Страница персонального раздела
				"PATH_TO_PROFILE" => PATH_TO_BASKET,	// Страница профиля
				"PATH_TO_REGISTER" => PATH_TO_AUTH,	// Страница регистрации
				"POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
				"SHOW_AUTHOR" => "N",	// Добавить возможность авторизации
				"SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
				"SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
				"SHOW_PERSONAL_LINK" => "N",	// Отображать персональный раздел
				"SHOW_PRODUCTS" => "N",	// Показывать список товаров
				"SHOW_REGISTRATION" => "N",	// Добавить возможность регистрации
				"SHOW_TOTAL_PRICE" => "N",	// Показывать общую сумму по товарам
			),
				false
			);?>
		</div>
	</div>
</div>

<?
if (SITE_DIR !== $dir) {
	$APPLICATION->IncludeComponent("bitrix:breadcrumb", "main", Array(
		"PATH" => "",    // Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
		"SITE_ID" => "s1",    // Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
		"START_FROM" => "0",    // Номер пункта, начиная с которого будет построена навигационная цепочка
	),
		false
	);
}
?>