<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Клубные карты");
?>
    <div class="content__wrapper-brand-is">
        <h1 class="page-name"><?$APPLICATION->ShowTitle(false);?></h1>

        <div class="section__cards">
            <p class="cards__text-block">
                Клубная карта выдается Вам с первой покупкой на сайте NELLEX.SHOP или в нашем фирменном магазине VILERMO. Данная карта является
                накопительной и Ваша скидка будет увеличиваться пропорционально Вашим накоплениям (покупкам)на карте.
            </p>
            <div class="flex-row cards__img-block">
                <div class="card__img-item">
                    <div class="img__card-titlr">Сумма покупок</div>
                    <div class="img__card-sum">от  1 000 руб </div>
                    <div class="img__card-dc">3%</div>
                </div>
                <div class="card__img-item">
                    <div class="img__card-titlr">Сумма покупок</div>
                    <div class="img__card-sum">от  5 000 руб </div>
                    <div class="img__card-dc">5%</div>
                </div>
                <div class="card__img-item">
                    <div class="img__card-titlr">Сумма покупок</div>
                    <div class="img__card-sum">от  10 000 руб </div>
                    <div class="img__card-dc">7%</div>
                </div>
                <div class="card__img-item">
                    <div class="img__card-titlr">Сумма покупок</div>
                    <div class="img__card-sum">от  30 000 руб </div>
                    <div class="img__card-dc">10%</div>
                </div>
            </div>
            <p class="cards__text-block">
                Клубные карты выдаются только при заполнении анкетных данных на сайте NELLEX.SHOP или в фирменном магазине VILERMO и являются
                собственностью компании NELLEX.
            </p>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>