<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var array $arParams
 * @var array $arResult
 */

if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']) ShowMessage($arResult['ERROR_MESSAGE']);
