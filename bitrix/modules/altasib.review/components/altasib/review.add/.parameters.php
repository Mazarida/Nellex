<?
#################################################
#        Company developer: ALTASIB
#        Developer: Evgeniy Pedan
#        Site: http://www.altasib.ru
#        E-mail: dev@altasib.ru
#        Copyright (c) 2006-2013 ALTASIB
#################################################
?>
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
                return;

$arIBlockType = array();
$rsIBlockType = CIBlockType::GetList(array("sort"=>"asc"), array("ACTIVE"=>"Y"));
while ($arr=$rsIBlockType->Fetch())
    if($ar=CIBlockType::GetByIDLang($arr["ID"], LANGUAGE_ID))
        $arIBlockType[$arr["ID"]] = "[".$arr["ID"]."] ".$ar["NAME"];

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
    $arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
    $arIBlockToUrl[$arr["ID"]] = $arr;
}
$arCurrentValues["SEF_BASE_URL"] = $arIBlockToUrl[$arCurrentValues["IBLOCK_ID"]]["LIST_PAGE_URL"];
$arCurrentValues["SECTION_PAGE_URL"] = str_replace($arCurrentValues["SEF_BASE_URL"],"",$arIBlockToUrl[$arCurrentValues["IBLOCK_ID"]]["SECTION_PAGE_URL"]);
$arCurrentValues["DETAIL_PAGE_URL"] = str_replace($arCurrentValues["SEF_BASE_URL"],"",$arIBlockToUrl[$arCurrentValues["IBLOCK_ID"]]["DETAIL_PAGE_URL"]);

$obGroups = CGroup::GetList(($by="id"), ($order="desc"));
while($arGroup = $obGroups->Fetch())
	$arGroups[$arGroup["ID"]] = $arGroup["NAME"];

if($arCurrentValues["SAVE_RATING"] == "Y")
{
	$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
	while ($arr=$rsProp->Fetch())
	{
		if (in_array($arr["PROPERTY_TYPE"], array("N", "S")))
			$arProps[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("ALTASIB_REVIEW",0,LANGUAGE_ID);
$arUFF = array();
$arUFVot = Array();
foreach($arUF as $k=>$arUF)
{
    if($arUF['USER_TYPE_ID']=='ALTASIB_REVIEW_RATING')
    {
        $arUFVot[$k] = $arUF["EDIT_FORM_LABEL"];
        unset($arUF[$k]);
    }
    else
    {
        $arUFF[$k] = $arUF["EDIT_FORM_LABEL"];
        unset($arUF[$k]);
    }
}

$arComponentParameters = array(
    "GROUPS" => array(
        "FIELDS"=> Array("NAME"=>GetMessage("ALTASIB_PM_FIELDS")),                
        "FILES"=> Array("NAME"=>GetMessage("ALTASIB_REVIEW_CMP_FILES_SETTING")),
    ),
    "PARAMETERS" => array(
//DATA                
        "IBLOCK_TYPE" => array(
                        "PARENT" => "DATA_SOURCE",
                        "NAME" => GetMessage("ALTASIB_PM_IBLOCK_TYPE"),
                        "TYPE" => "LIST",
                        "VALUES" => $arIBlockType,
                        "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
                        "PARENT" => "DATA_SOURCE",
                        "NAME" => GetMessage("ALTASIB_PM_IBLOCK_IBLOCK"),
                        "TYPE" => "LIST",
                        "ADDITIONAL_VALUES" => "Y",
                        "VALUES" => $arIBlock,
                        "REFRESH" => "Y",
        ),
        "IS_SEF" => array(
                        "PARENT" => "DATA_SOURCE",
                        "NAME" => GetMessage("ALTASIB_PM_IS_SEF"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
                        "REFRESH" => "Y",
        ),
        "SEF_BASE_URL" => array(
                        "PARENT" => "DATA_SOURCE",
                        "NAME"=>GetMessage("ALTASIB_PM_SEF_BASE_URL"),
                        "TYPE"=>"STRING",
                        "DEFAULT"=>$arCurrentValues["SEF_BASE_URL"]
        ),
        "SECTION_PAGE_URL" => CIBlockParameters::GetPathTemplateParam(
                        "SECTION",
                        "SECTION_PAGE_URL",
                        GetMessage("ALTASIB_PM_SECTION_PAGE_URL"),
                        $arCurrentValues["SECTION_PAGE_URL"],
                        "DATA_SOURCE"                                                
        ),
        "DETAIL_PAGE_URL" => CIBlockParameters::GetPathTemplateParam(
                        "DETAIL",
                        "DETAIL_PAGE_URL",
                        GetMessage("ALTASIB_PM_DETAIL_PAGE_URL"),
                        $arCurrentValues["DETAIL_PAGE_URL"],
                        "DATA_SOURCE"
        ),
        "ELEMENT_ID" => array(
                        "PARENT" => "DATA_SOURCE",
                        "NAME" => GetMessage("ALTASIB_PM_ELEMENT_ID"),
                        "TYPE" => "STRING",
                        "DEFAULT" => '={$_REQUEST["ELEMENT_ID"]}',
        ),
        "ELEMENT_CODE" => array(
                        "PARENT" => "DATA_SOURCE",
                        "NAME" => GetMessage("ALTASIB_PM_ELEMENT_CODE"),
                        "TYPE" => "STRING",
                        "DEFAULT" => '={$_REQUEST["ELEMENT_CODE"]}',
        ),
//BASE
        "USE_CAPTCHA" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_USE_CAPTCHA"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "Y",
        ),
        "ALLOW_TITLE" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_ALLOW_TITLE"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
        ),
        "MOD_GOUPS" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_MODERATING_GROUPS"),
                        "TYPE" => "LIST",
                        "VALUES" => $arGroups,
						"MULTIPLE" => "Y",
        ),
        "ONLY_AUTH_SEND" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_REVIEW_ADD_PM_ONLY_AUTH_SEND"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
        ),

        "COMMENTS_MODE" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_COMMENTS_MODE"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
						"REFRESH" => "Y",
        ),
        "SAVE_RATING" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_SAVE_RATING"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
						"REFRESH" => "Y",
        ),
        "MODERATE" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_MODERATE"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
        ),        
        "MODERATE_LINK" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_MODERATE_LINK"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
        ),                                        
        "REG_URL" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_REG_URL"),
                        "TYPE" => "STRING",
                        "DEFAULT" => '/auth/?register=yes',
        ),        
//VISUAL
        "UF" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_NAME_UF"),
                        "TYPE" => "LIST",
                        "MULTIPLE" => "Y",
                        "VALUES" => $arUFF,
        ),    
        "UF_VOTE" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_NAME_UF_VOTE"),
                        "TYPE" => "LIST",
                        "MULTIPLE" => "Y",
                        "VALUES" => $arUFVot,
        ),                                
        "MESSAGE_OK" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_MESSAGE_OK"),
                        "TYPE" => "STRING",
                        "DEFAULT" => GetMessage("ALTASIB_MESSAGE_OK"),
        ),
        "ADD_TITLE" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_REVIEW_CMP_PM_ADD_TITLE"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "",
        ),
        
        "NOT_HIDE_FORM" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_NOT_HIDE_FORM"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
        ),
        "SHOW_CNT" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_SHOW_CNT"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
        ),        
        
//FIELDS
        "REQUIRED_RATING" => array(
                        "PARENT" => "FIELDS",
                        "NAME" => GetMessage("ALTASIB_PM_REQUIRED_RATING"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "Y",
        ),

        "PLUS_TEXT_MIN_LENGTH" => array(
                        "PARENT" => "FIELDS",
                        "NAME" => GetMessage("ALTASIB_PM_PLUS_TEXT_MIN_LENGTH"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "5",
        ),								
        "PLUS_TEXT_MAX_LENGTH" => array(
                        "PARENT" => "FIELDS",
                        "NAME" => GetMessage("ALTASIB_PM_PLUS_TEXT_MAX_LENGTH"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "",
        ),
        
        "MINUS_TEXT_MIN_LENGTH" => array(
                        "PARENT" => "FIELDS",
                        "NAME" => GetMessage("ALTASIB_PM_MINUS_TEXT_MIN_LENGTH"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "",
        ),								
        "MINUS_TEXT_MAX_LENGTH" => array(
                        "PARENT" => "FIELDS",
                        "NAME" => GetMessage("ALTASIB_PM_MINUS_TEXT_MAX_LENGTH"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "",
        ),
                                        
        "MIN_LENGTH" => array(
                        "PARENT" => "FIELDS",
                        "NAME" => GetMessage("ALTASIB_PM_MIN_LENGTH"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "5",
        ),								
        "MAX_LENGTH" => array(
                        "PARENT" => "FIELDS",
                        "NAME" => GetMessage("ALTASIB_PM_MAX_LENGTH"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "",
        ),
    ),
);
if($arCurrentValues["SAVE_RATING"] == "Y")
{
				$arComponentParameters["PARAMETERS"]["SAVE_RATING_IB_PROPERTY"] = Array(
								"PARENT" => "BASE",
								"NAME" => GetMessage("ALTASIB_PM_SAVE_RATING_IB_PROPERTY"),
								"VALUES" => $arProps,
								"MULTIPLE" => "Y",
								"ADDITIONAL_VALUES" => "Y",
								"DEFAULT" => "RATING",
								"MULTIPLE" => "N",
								"TYPE" => "LIST",
	);				
}

$arComponentParameters["PARAMETERS"]["ALLOW_UPLOAD_FILE"] = Array(
	"PARENT" => "FILES",
    "NAME" => GetMessage("ALTASIB_PM_ALLOW_UPLOAD_FILE"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "Y",
);

$arComponentParameters["PARAMETERS"]["UPLOAD_FILE_TYPE"] = Array(
	"PARENT" => "FILES",
    "NAME" => GetMessage("ALTASIB_PM_UPLOAD_FILE_TYPE"),
    "TYPE" => "STRING",
    "DEFAULT" => COption::GetOptionString("altasib.review","upload_file_types","jpg,jpeg,gif,png,ppt,doc,docx,xls,xlsx,odt,odp,ods,odb,rtf,txt"),
);   

$arComponentParameters["PARAMETERS"]["UPLOAD_FILE_SIZE"] = Array(
	"PARENT" => "FILES",
    "NAME" => GetMessage("ALTASIB_PM_UPLOAD_FILE_SIZE"),
    "TYPE" => "STRING",
    "DEFAULT" => COption::GetOptionString("altasib.review","upload_file_size","150"),
);     

if($arCurrentValues["IS_SEF"] === "Y")
{
    unset($arComponentParameters["PARAMETERS"]["ELEMENT_ID"]);
    unset($arComponentParameters["PARAMETERS"]["ELEMENT_CODE"]);
    unset($arComponentParameters["PARAMETERS"]["SECTION_URL"]);
}
else
{
    unset($arComponentParameters["PARAMETERS"]["SEF_BASE_URL"]);
    unset($arComponentParameters["PARAMETERS"]["DETAIL_PAGE_URL"]);
    unset($arComponentParameters["PARAMETERS"]["SECTION_PAGE_URL"]);
}
?>