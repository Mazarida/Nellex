<?include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("404 Not Found");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");?>

<div class="notfound">
    <h2>404</h2>
    <p><strong>Здравствуйте, уважаемый посетитель.</strong></p>
    <p><strong>К сожалению, запрашиваемой Вами страницы не существует на нашем сайте.</strong></p>
    <p><strong>Возможно, это случилось по одной из этих причин:</strong></p>
    <ul>
        <li>Вы ошиблись при наборе адреса страницы (URL)</li>
        <li>Перешли по "битой" (неработающей) ссылке</li>
        <li>Запрашиваемой страницы никогда не было на сайте или она была удалена</li>
    </ul>
    <p><strong>Мы просим прощения за доставленные неудобства и предлагаем следующие пути:</strong></p>
    <ul>
        <li>Вернуться назад при помощи кнопки браузера "back"</li>
        <li>Проверить правильность написания адреса страницы (URL)</li>
        <li>Перейти на <a href="<?=SITE_DIR?>">главную страницу сайта</a></li>
        <?/*<li>Воспользоваться <a href="<?=SITE_DIR.'site_map.php'?>">картой сайта</a> или поиском</li>*/?>
    </ul>
    <p>Если Вы уверены в правильности набранного адреса страницы и считаете, что эта ошибка произошла по нашей вине, пожалуйста, сообщите об этом при помощи контактной формы.</p>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
