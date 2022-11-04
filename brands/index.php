<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("Бренды");

$arBrand = array();
if (\Bitrix\Main\Loader::includeModule('highloadblock')) {
    if ($entity_data_class = GetEntityDataClass(HLBLOCK_ID__BRANDS)) {
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME', 'UF_FILE', 'UF_DETAIL_PICTURE', 'UF_FULL_DESCRIPTION', 'UF_XML_ID'),
            'filter' => array(),
            'order' => array('UF_SORT' => 'ASC'),
        ));

        while($item = $rsData->fetch()){
            $arBrand[] = array(
                "NAME" => $item["UF_NAME"],
                "SRC" => CFile::GetPath($item["UF_FILE"]),
                "BIG_SRC" => CFile::GetPath($item["UF_DETAIL_PICTURE"]),
                "DESC" => $item["UF_FULL_DESCRIPTION"],
                "XML_ID" => $item["UF_XML_ID"],
            );
        }
    }
}
?>

<div class="content__wrapper-brand">
    <h1 class="page-name"><?$APPLICATION->ShowTitle(false);?></h1>

    <div class="section__brands">
        <?if (count($arBrand)):?>
            <?foreach ($arBrand as $item):?>
                <div id="<?=$item['XML_ID']?>" class="flex-row brands-item-row">
                    <div class="brands__item-img" style="background-image: url('<?=$item['BIG_SRC']?>');"></div>
                    <div class="brands__item-desc">
                        <div class="brands__img im-vilermo-i" style="background-image: url('<?=$item['SRC']?>'); background-position: left;"></div>
                        <p class="brands__desc" style="text-align: left;"><?=$item['DESC']?></p>
                    </div>
                </div>
            <?endforeach;?>
        <?endif;?>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
