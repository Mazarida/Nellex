<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arResult
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if (\Bitrix\Main\Loader::includeModule('highloadblock')) {
    // Каротинки цветов
    if (isset($arResult['DISPLAY_PROPERTIES']['COLOR']) && is_array($arResult['DISPLAY_PROPERTIES']['COLOR']['VALUE'])) {
        if ($entity_data_class = GetEntityDataClass(HLBLOCK_ID__COLORS)) {
            $rsData = $entity_data_class::getList(array(
                'select' => array('UF_FILE', 'UF_XML_ID'),
                'filter' => array('UF_XML_ID' => $arResult['DISPLAY_PROPERTIES']['COLOR']['VALUE'])
            ));

            while ($item = $rsData->fetch()) {
                $arResult['DISPLAY_PROPERTIES']['COLOR']['SRC'][$item['UF_XML_ID']] = CFile::GetPath($item["UF_FILE"]);
            }
        }
    }

    // Картинка бренда
    if (isset($arResult['DISPLAY_PROPERTIES']['BRAND']) && strlen($arResult['DISPLAY_PROPERTIES']['BRAND']['VALUE'])) {
        if ($entity_data_class = GetEntityDataClass(HLBLOCK_ID__BRANDS)) {
            $rsData = $entity_data_class::getList(array(
                'select' => array('UF_FILE'),
                'filter' => array('UF_XML_ID' => $arResult['DISPLAY_PROPERTIES']['BRAND']['VALUE'])
            ));

            while ($item = $rsData->fetch()) {
                $arResult['DISPLAY_PROPERTIES']['BRAND']['SRC'] = CFile::GetPath($item["UF_FILE"]);
            }
        }
    }

    if (\Bitrix\Main\Loader::includeModule('sale')) {
        // Все платежные системы
        $arSelect = array("ID", "NAME", "LOGOTIP", "PS_DESCRIPTION");
        $arFilter = array("ACTIVE" => "Y");
        $obPaySystem = CSalePaySystemAction::GetList(array(), $arFilter, false, false, $arSelect);
        if (is_array($obPaySystem->arResult) && count($obPaySystem->arResult)) {
            foreach ($obPaySystem->arResult as $item) {
                $arResult["PAY_SYSTEMS"][] = array(
                    "ID" => $item["ID"],
                    "NAME" => $item["NAME"],
                    "SRC" => CFile::GetPath($item["LOGOTIP"]),
                    "DESC" => $item["PS_DESCRIPTION"],
                );
            }
        }
        //PR($arResult["PAY_SYSTEMS"]);

        // Все спсобы доставки
        $arSelect = array("ID", "NAME", "LOGOTIP", "DESCRIPTION");
        $arFilter = array("ACTIVE" => "Y");
        $obDelivery = CSaleDelivery::GetList(array(), $arFilter, false, false, $arSelect);
        if (is_array($obDelivery->arResult) && count($obDelivery->arResult)) {
            foreach ($obDelivery->arResult as $item) {
                $arResult["DELIVERY_METHODS"][] = array(
                    "ID" => $item["ID"],
                    "NAME" => $item["NAME"],
                    "SRC" => CFile::GetPath($item["LOGOTIP"]),
                    "DESC" => $item["DESCRIPTION"],
                );
            }
        }
        //PR($arResult["DELIVERY_METHODS"]);
    }
}