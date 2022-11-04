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

if(!CModule::IncludeModule("iblock") ||
   !CModule::IncludeModule("altasib.review"))
                return;

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
$timestamp = time();
$arComponentParameters = array(
    "GROUPS" => array(
	    "PAGE_SETTINGS"=> Array("NAME"=>GetMessage("ALTASIB_REVIEW_CMP_PM_PAGE_SETTINGS")),
    ),
    "PARAMETERS" => array(
//DATA                
//BASE                                
        "COMMENTS_MODE" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_COMMENTS_MODE"),
                        "TYPE" => "CHECKBOX",
                        "DEFAULT" => "N",
						"REFRESH" => "Y",
        ),
        "USER_PATH" => array(
                        "PARENT" => "BASE",
                        "NAME" => GetMessage("ALTASIB_PM_USER_PATH"),
                        "TYPE" => "STRING",
                        "DEFAULT" => '',
        ),        
//VISUAL           
        "UF_VOTE" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_NAME_UF_VOTE"),
                        "TYPE" => "LIST",
                        "MULTIPLE" => "Y",
                        "VALUES" => $arUFVot,
        ),                 
        "POST_DATE_FORMAT" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_POST_DATE_FORMAT"),
                        "TYPE" => "LIST",
                        "ADDITIONAL_VALUES" => "N",
                        "VALUES" => Array(
                                        "j M Y" => aReview::FormatDate("j M Y", $timestamp),//"22 Feb 2007",
                                        "M j, Y" => aReview::FormatDate("M j, Y", $timestamp),//"Feb 22, 2007",
                                        "j F Y" => aReview::FormatDate("j F Y", $timestamp),//"22 February 2007",
                                        "j F Y, H:i" => aReview::FormatDate("j F Y, H:i", $timestamp),//"22 February 2007, 03:00",
                                        "Tj F Y, H:i" => aReview::FormatDate("Tj F Y, H:i", $timestamp),//"today, 03:00",
                                        "F j, Y" => aReview::FormatDate("F j, Y", $timestamp),//"February 22, 2007",
                                        "d-m-Y" => aReview::FormatDate("d-m-Y", $timestamp),//"22-02-2007",
                                        "d.m.Y" => aReview::FormatDate("d.m.Y", $timestamp),//"22.02.2007",
                        ),
        ),

        "NAME_SHOW_TYPE" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_NAME_SHOW_TYPE"),
                        "TYPE" => "LIST",
                        "ADDITIONAL_VALUES" => "N",
                        "VALUES" => Array(
                                "LOGIN"=>GetMessage("ALTASIB_PM_NAME_SHOW_TYPE_LOGIN"),
                                "NAME"=>GetMessage("ALTASIB_PM_NAME_SHOW_TYPE_NAME"),
                                "NAME_LAST_NAME"=>GetMessage("ALTASIB_PM_NAME_SHOW_TYPE_NAME_LAST_NAME"),
                                "LOGIN_NAME"=>GetMessage("ALTASIB_PM_NAME_SHOW_TYPE_LOGIN_NAME"),
                                "LOGIN_NAME_LAST_NAME"=>GetMessage("ALTASIB_PM_NAME_SHOW_TYPE_LOGIN_NAME_LAST_NAME")
                        ),
        ),
        "SHOW_AVATAR_TYPE" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_SHOW_AVATAR"),
                        "TYPE" => "LIST",
                        "ADDITIONAL_VALUES" => "N",
                        "VALUES" => Array(
                                "ns"=>GetMessage("ALTASIB_PM_AVATAR_TYPE_0"),
                                "user"=>GetMessage("ALTASIB_PM_AVATAR_TYPE_1"),
                                "forum"=>GetMessage("ALTASIB_PM_AVATAR_TYPE_2"),
                                "blog"=>GetMessage("ALTASIB_PM_AVATAR_TYPE_3")
                        ),
        ),
        
        "AVATAR_WIDTH" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_AVATAR_WIDTH"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "80",
        ),
        "AVATAR_HEIGHT" => array(
                        "PARENT" => "VISUAL",
                        "NAME" => GetMessage("ALTASIB_PM_AVATAR_HEIGHT"),
                        "TYPE" => "STRING",
                        "DEFAULT" => "80",
        ),                                   
//PAGER                                
		"REVIEWS_ON_PAGE" => array(
			"PARENT" => "PAGE_SETTINGS",
			"NAME" => GetMessage("ALTASIB_REVIEW_CMP_PM_REVIEWS_SHOW"),
			"TYPE" => "STRING",
			"DEFAULT" => '15',
		),
        
		"NAV_TEMPLATE" => array(
			"PARENT" => "PAGE_SETTINGS",
			"NAME" => GetMessage("ALTASIB_PM_NAV_TEMPLATE"),
			"TYPE" => "STRING",
			"DEFAULT" => 'arrows',
		),        
        "CACHE_TIME"  =>  Array("DEFAULT"=>3600),                                                             
    ),
);
?>