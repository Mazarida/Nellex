<?
$arBrand = array();
if (\Bitrix\Main\Loader::includeModule('highloadblock')) {
    if ($entity_data_class = GetEntityDataClass(HLBLOCK_ID__BRANDS)) {
        $rsData = $entity_data_class::getList(array(
            'select' => array('UF_NAME', 'UF_FILE', 'UF_LINK', 'UF_DESCRIPTION'),
            'filter' => array(),
            'order' => array('UF_SORT' => 'ASC'),
            'limit' => 3,
        ));

        while($item = $rsData->fetch()){
            $arBrand[] = array(
                "NAME" => $item["UF_NAME"],
                "SRC" => CFile::GetPath($item["UF_FILE"]),
                "LINK" => $item["UF_LINK"],
                "DESC" => $item["UF_DESCRIPTION"],
            );
        }
    }
}
?>

<?if (count($arBrand)):?>
    <div class="flex-row sc5__brands-about-row">
        <?foreach ($arBrand as $item):?>
            <div class="sc5__brand-about">
                <div class="sc5__brand-img" style="background-image: url('<?=$item['SRC']?>')"></div>
                <div class="sc5__brand-text"><?=$item['DESC']?></div>
                <a href="<?=$item['LINK']?>" class="sc5__brand-btn">Подробнее</a>
            </div>
        <?endforeach;?>
    </div>
<?endif;?>