<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arParams
 * @var array $arResult
 */

use Bitrix\Main\Localization\Loc,
    Bitrix\Sale;

$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_ORDER_HISTORY"));

// Список всех заказов пользователя
$arOrders = array();
$arStatus = array();
$arPayments = array();
if (\Bitrix\Main\Loader::includeModule('sale')) {
    $statusResult = \Bitrix\Sale\Internals\StatusLangTable::getList(array(
        'order' => array('STATUS.SORT' => 'ASC'),
        'filter' => array('STATUS.TYPE' => 'O', 'LID' => LANGUAGE_ID),
        'select' => array('STATUS_ID', 'NAME'),
    ));

    while($status = $statusResult->fetch()) {
        $arStatus[$status['STATUS_ID']] = $status["NAME"];
    }

    $arFilter = Array(
        "USER_ID" => $USER->GetID(),
        //">=DATE_INSERT" => date($DB->DateFormatToPHP(CSite::GetDateFormat("SHORT")), mktime(0, 0, 0, date("n"), 1, date("Y")))
    );

    $db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter);
    while ($ar_sales = $db_sales->Fetch()) {
        $arOrders[] = $ar_sales;
        //echo $ar_sales["DATE_INSERT_FORMAT"]."<br>";
    }

    if (count($arOrders)) {
        foreach ($arOrders as $arItem){
            $arPayment = CSaleExport::getPayment($arItem);
            foreach ($arPayment['payment'] as $payment){
                if ($arItem['PAYED'] == 'N' && $arItem['CANCELED'] == 'N'){
                    if (!empty($arItem['PAY_SYSTEM_ID'])) {
                        if (intval($payment["PAY_SYSTEM_ID"])) {
                            $payment["PAY_SYSTEM"] = \Bitrix\Sale\PaySystem\Manager::getById($payment["PAY_SYSTEM_ID"]);
                            $payment["PAY_SYSTEM"]['NAME'] = htmlspecialcharsbx($payment["PAY_SYSTEM"]['NAME']);
                        }
                        if ($arItem['PAYED'] == 'N' && $arItem['CANCELED'] == 'N') {
                            $payment['BUFFERED_OUTPUT'] = '';
                            $payment['ERROR'] = '';
                            $service = new \Bitrix\Sale\PaySystem\Service($payment["PAY_SYSTEM"]);
                            if ($service) {
                                $payment["CAN_REPAY"] = "Y";
                                if ($service->getField("NEW_WINDOW") == "Y") {
                                    $payment["PAY_SYSTEM"]["PSA_ACTION_FILE"] = htmlspecialcharsbx("PATH_TO_PAYMENT").'?ORDER_ID='.urlencode(urlencode($arItem['ACCOUNT_NUMBER'])).'&PAYMENT_ID='.$payment['ID'];
                                } else {
                                    CSalePaySystemAction::InitParamArrays($arItem, $arItem["ID"], '', array(), $payment);

                                    $handlerFolder = \Bitrix\Sale\PaySystem\Manager::getPathToHandlerFolder($service->getField('ACTION_FILE'));
                                    $pathToAction = \Bitrix\Main\Application::getDocumentRoot().$handlerFolder;
                                    $pathToAction = str_replace("\\", "/", $pathToAction);
                                    while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
                                        $pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);
                                    if (file_exists($pathToAction)) {
                                        if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
                                            $pathToAction .= "/payment.php";
                                        $payment["PAY_SYSTEM"]["PSA_ACTION_FILE"] = $pathToAction;
                                    }

                                    $encoding = $service->getField("ENCODING");
                                    if (strlen($encoding) > 0) {
                                        define("BX_SALE_ENCODING", $encoding);
                                        AddEventHandler("main", "OnEndBufferContent", array($this, "changeBodyEncoding"));
                                    }

                                    /** @var \Bitrix\Sale\Order $order */
                                    $order = \Bitrix\Sale\Order::load($arItem["ID"]);

                                    if ($order) {
                                        /** @var \Bitrix\Sale\PaymentCollection $paymentCollection */
                                        $paymentCollection = $order->getPaymentCollection();
                                        if ($paymentCollection) {
                                            /** @var \Bitrix\Sale\Payment $paymentItem */
                                            $paymentItem = $paymentCollection->getItemById($payment['ID']);
                                            if ($paymentItem) {
                                                $initResult = $service->initiatePay($paymentItem, null, \Bitrix\Sale\PaySystem\BaseServiceHandler::STRING);
                                                if ($initResult->isSuccess())
                                                    $payment['BUFFERED_OUTPUT'] = $initResult->getTemplate();
                                                else
                                                    $payment['ERROR'] = implode('\n', $initResult->getErrorMessages());
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $arPayments['PAYMENT_SYSTEM'][$arItem['ID']][] = $payment;
                    }
                }
            }
        }
    }
}
?>

<?if (count($arStatus) && count($arOrders)):?>
    <table class="order__hist-table">
        <tr class="orderr__hist-throw">
            <th class="order-hist-tdh nzak"><?=Loc::getMessage('ORDER_NUMBER_TABLE_TITLE')?></th>
            <th class="order-hist-tdh statd"><?=Loc::getMessage('ORDER_PAYED_TABLE_TITLE')?></th>
            <th class="order-hist-tdh statusd"><?=Loc::getMessage('ORDER_STATUS_TABLE_TITLE')?></th>
            <th class="order-hist-tdh dotpr"><?=Loc::getMessage('ORDER_DATE_DELIVERY_TABLE_TITLE')?></th>
            <th class="order-hist-tdh dpoluch"><?=Loc::getMessage('ORDER_DATE_RECEIPT_TABLE_TITLE')?></th>
        </tr>
        <?foreach ($arOrders as $key => $item):?>
            <tr class="orderr__hist-trow">
                <th class="order-hist-td nzak"><?=$item["ID"]?></th>
                <th class="order-hist-td statd">
                    <?=$item["PAYED"] === "Y" ? Loc::getMessage('PAYMENT_TEXT') : Loc::getMessage('NOT_PAYMENT_TEXT')?>
                    <?
                    $cur_payment = $arPayments["PAYMENT_SYSTEM"][$item["ID"]][0];
                    if ($cur_payment["CAN_REPAY"] == "Y" && $cur_payment["PAY_SYSTEM"]["PSA_NEW_WINDOW"] != "Y") {
                        if (array_key_exists('ERROR', $cur_payment) && strlen($cur_payment['ERROR']) > 0) {
                            ShowError($cur_payment['ERROR']);
                        } elseif (array_key_exists('BUFFERED_OUTPUT', $cur_payment)) {
                            echo $cur_payment['BUFFERED_OUTPUT'];
                        }
                    }
                    ?>
                </th>
                <th class="order-hist-td statusd"><?=$arStatus[$item["STATUS_ID"]]?></th>
                <th class="order-hist-td dotpr"><?=!empty($item["DATE_INSERT"]) ? FormatDate("d | m | Y", MakeTimeStamp($item["DATE_INSERT"])) : '-- | -- | ----'?></th>
                <th class="order-hist-td dpoluch"><?=!empty($item["DATE_DEDUCTED"]) ? FormatDate("d | m | Y", MakeTimeStamp($item["DATE_DEDUCTED"])) : '-- | -- | ----'?></th>
            </tr>
        <?endforeach;?>
    </table>
<?endif;?>

<?//PR($arOrders);?>
<?//PR($arPayments);?>