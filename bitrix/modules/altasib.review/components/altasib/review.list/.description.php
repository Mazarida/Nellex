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

$arComponentDescription = array(
    "NAME" => GetMessage("ALTASIB_DESC_REVIEW_NAME"),
    "DESCRIPTION" => GetMessage("ALTASIB_DESC_REVIEW_DESCRIPTION"),
    "ICON" => "/images/icon.gif",
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "IS-MARKET.RU",
        "NAME" => GetMessage("ALTASIB_DESC_SECTION_NAME"),
        "CHILD" => array(
                        "ID" => "altasib_review_cmpx",
                        "NAME" => GetMessage("ALTASIB_DESC_REVIEW_SECTION_NAME"),
        ),
    ),
);
?>