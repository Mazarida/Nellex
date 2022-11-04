<?
//use \Bitrix\Main\Loader;

//$eventManager = \Bitrix\Main\EventManager::getInstance();

//page start
//AddEventHandler("main", "OnPageStart", "loadLocalLib", 1);
//function loadLocalLib()
//{
//    Loader::includeModule('local.lib');
//}

// Письмо пользователю при оформлении нового заказа
//AddEventHandler("sale", "OnOrderNewSendEmail", "ModifyOrderSaleMails");
//
//function ModifyOrderSaleMails($orderID, &$eventName, &$arFields)
//{
//    $fp = fopen('fields.txt', 'w');
//    fwrite($fp, print_r($arFields), true);
//    fclose($fp);
//}
