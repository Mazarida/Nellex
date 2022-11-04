<?
#################################################
#        Company developer: ALTASIB
#        Developer: Evgeniy Pedan
#        Site: http://www.altasib.ru
#        E-mail: dev@altasib.ru
#        Copyright (c) 2006-2011 ALTASIB
#################################################
?>
<?
IncludeModuleLangFile(__FILE__);

$GROUP_RIGHT = $APPLICATION->GetGroupRight("altasib.review");

if($GROUP_RIGHT>"D")
{
	$aMenu = array(
			"parent_menu" => "global_menu_services",
			"section" => "altasib_review",
			"sort" => 10,
			"text" => GetMessage("ALTASIB_REVIEW_MENU_TEXT"),
			"title" => GetMessage("ALTASIB_REVIEW_MENU_TITILE"),
			"url" => "altasib_review_index.php?lang=".LANGUAGE_ID,
			"icon" => "menu_altasib_review",
			"page_icon" => "altasib_review_page_icon",
			"items_id" => "altasib_review",
			"items" => array()

			);
			if($GROUP_RIGHT >= "M")
			{
				$aMenu["items"][] = array(
					"text" => GetMessage("ALTASIB_REVIEW_MENU_SECTION_TEXT"),
					"url" => "altasib_review_section.php?lang=".LANGUAGE_ID,
					"title" => GetMessage("ALTASIB_REVIEW_MENU_SECTION_TITLE")
				);
				$aMenu["items"][] = array(
					"text" => GetMessage("ALTASIB_REVIEW_MENU_LIST_TEXT"),
					"url" => "altasib_review_list.php?lang=".LANGUAGE_ID,
					"title" => GetMessage("ALTASIB_REVIEW_MENU_LIST_TITLE")
				);												
			}

			if($GROUP_RIGHT >= "M")
				$aMenu["items"][] = array(
					"text" => GetMessage("ALTASIB_REVIEW_MENU_ABUSE_TEXT"),
					"url" => "altasib_review_complaint.php?lang=".LANGUAGE_ID,
					"title" => GetMessage("ALTASIB_REVIEW_MENU_ABUSE_TITLE")
				);
            if($GROUP_RIGHT == "W")
            {
				$aMenu["items"][] = array(
					"text" => GetMessage("ALTASIB_REVIEW_MENU_RATING_TEXT"),
					"url" => "altasib_review_rating.php?lang=".LANGUAGE_ID,
					"title" => GetMessage("ALTASIB_REVIEW_MENU_RATING_TITLE")
				);                
            }
                return $aMenu;
}
return false;
?>