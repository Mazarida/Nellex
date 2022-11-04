<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О нас");
?>
<div class="content__wrapper-brand">
    <h1 class="page-name"><?$APPLICATION->ShowTitle(false);?></h1>

    <div class="section__brands">
        <div class="flex-row brands-item-row">
            <div class="brands__item-img" style="background-image: url('/local/templates/nellex/img/about.png')"></div>
            <div class="brands__item-desc">
                <div class="brands__img im-vilermo-i" style="background-image: url('/local/templates/nellex/img/header__logo.png'); background-position: left;"></div>
                <p class="brands__desc" style="text-align: left;">
                    Приветствуем тебя, наш Дорогой Покупатель! <br>
                    <br>
                    Мы являемся производителями головных уборов и аксессуаров, торговых марок  VILERMO, REGARZO, NELL и TEZZA. <br>
                    В нашем интернет-магазине мы хотим предложить Вам полный ассортиментный ряд нашей продукции, рассчитанный на любой пол, возраст и вкус! <br>
                    <br>
                    Мы старались учесть все Ваши потребности и пожелания. <br>
                    Спасибо, что выбрали нас. Приятных покупок! <br>
                    <br>
                </p>
            </div>
        </div>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>