<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arResult
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult)) {
	return "";
}

$strReturn = '';

$strReturn .= '<div class="breadcrumbs__navxt">';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > 0 ? ' <span class="delimiter">&gt;</span> ' : '');

	if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
		$strReturn .=  $arrow.'<a href="'.$arResult[$index]["LINK"].'" class="crumb__item">'.$title.'</a>';
	} else {
		$strReturn .= $arrow.'<div class="crumb__item">'.$title.'</div>';
	}
}

$strReturn .= '</div>';

return $strReturn;
