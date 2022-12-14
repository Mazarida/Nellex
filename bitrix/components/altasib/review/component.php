<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2018 ALTASIB
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("ALTASIB_CP_REVIEW_IBLOCK_MODULE_NOT_INSTALLED"));
	return;
}
if(!CModule::IncludeModule("altasib.review"))
{
	ShowError(GetMessage("ALTASIB_CP_REVIEW_MODULE_NOT_INSTALLED"));
	return;	
}

$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);
$arParams["ELEMENT_ID"] = intval($arParams["ELEMENT_ID"]);
$arParams["ELEMENT_CODE"] = trim($arParams["ELEMENT_CODE"]);

$arComponentVariables = array("SECTION_ID", "ELEMENT_ID","ID", "SECTION_CODE", "ELEMENT_CODE", "CODE");
$arVariableAliases = array(
				"section" => array("SECTION_ID" => "SECTION_ID","SECTION_CODE" => "SECTION_CODE"),
				"detail" => array("SECTION_ID" => "SECTION_ID", "ELEMENT_ID" => "ELEMENT_ID","ELEMENT_ID" => "ID", 
					"SECTION_CODE" => "SECTION_CODE", "ELEMENT_CODE" => "ELEMENT_CODE", "CODE" => "ELEMENT_CODE"),
			);
$arVariables = array();

if($arParams["IS_SEF"] === "Y" || $arParams["CATALOG_IS_SEF"] === "Y")
{
	$engine = new CComponentEngine($this);
	if (CModule::IncludeModule('iblock'))
	{
		$engine->addGreedyPart("#SECTION_CODE_PATH#");
		$engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
	}

	$componentPage = $engine->guessComponentPath(
		$arParams["SEF_BASE_URL"],
		array(
			"section" => $arParams["SECTION_PAGE_URL"],
			"detail" => $arParams["DETAIL_PAGE_URL"],
		),
		$arVariables
	);
	if($componentPage === "detail")
	{
		CComponentEngine::initComponentVariables(
			$componentPage,
			$arComponentVariables,
			$arVariableAliases,
			$arVariables
		);
	}
}
else
{
	CComponentEngine::initComponentVariables(false, $arComponentVariables, array("SECTION_ID" => "SECTION_ID", "ELEMENT_ID" => "ELEMENT_ID", "ELEMENT_ID" => "ID",
					"SECTION_CODE" => "SECTION_CODE", "ELEMENT_CODE" => "ELEMENT_CODE", "ELEMENT_CODE" => "CODE"), $arVariables);
}

$arParams["ELEMENT_ID"] = intval($arVariables["ELEMENT_ID"]);
$arParams["ELEMENT_CODE"] = $arVariables["ELEMENT_CODE"];

if($arParams["ELEMENT_ID"]==0 && intval($arParams["~ELEMENT_ID"])>0)
	$arParams["ELEMENT_ID"] = intval($arParams["~ELEMENT_ID"]);

if(strlen($arParams["ELEMENT_CODE"])==0 && strlen($arParams["~ELEMENT_CODE"])>0)
	$arParams["ELEMENT_CODE"] = trim($arParams["~ELEMENT_CODE"]);

$this->IncludeComponentTemplate();
?>