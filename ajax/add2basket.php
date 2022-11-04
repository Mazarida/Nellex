<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$product_id = 0 < intval($_REQUEST['product_id']) ? intval($_REQUEST['product_id']) : 0;
$quantity = 1 < intval($_REQUEST['quantity']) ? intval($_REQUEST['quantity']) : 1;
$vendor_code = trim($_REQUEST['vendor_code']);
$brand = trim($_REQUEST['brand']);
$composition = trim($_REQUEST['composition']);
$color = $_REQUEST['color'];
$size = $_REQUEST['size'];

if ($product_id && strlen($color) && strlen($size) && \Bitrix\Main\Loader::includeModule('catalog') && \Bitrix\Main\Loader::includeModule('sale')) {
    if (Add2BasketByProductID(
        $product_id,
        $quantity,
        array(
            array("NAME" => "Артикул", "CODE" => "VENDOR_CODE", "VALUE" => $vendor_code),
            array("NAME" => "Бренд", "CODE" => "BRAND", "VALUE" => $brand),
            array("NAME" => "Состав", "CODE" => "COMPOSITION", "VALUE" => $composition),
            array("NAME" => "Цвет", "CODE" => "COLOR", "VALUE" => $color),
            array("NAME" => "Размер", "CODE" => "SIZE", "VALUE" => $size),
        )
    )) {
        $cntBasketItems = CSaleBasket::GetList(
            array(),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
            ),
            array()
        );
        if (intval($cntBasketItems)) {
            echo getAllCountr();
        }
    }
}

//PR($_REQUEST);
