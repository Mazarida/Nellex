<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 */

$arResult = array_chunk($arResult , ceil(count($arResult) / 4));

