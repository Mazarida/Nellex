<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2018 ALTASIB
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$templateAdd = '';
if($arParams['SHOW_POPUP']=='Y')
    $templateAdd = 'popup';
    
$APPLICATION->IncludeComponent("altasib:review.add", $templateAdd, $arParams,$component);?>

<?$APPLICATION->IncludeComponent("altasib:review.list", ".default", $arParams,$component);?>