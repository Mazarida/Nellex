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
$dbEvent = CEventMessage::GetList($b="ID", $order="ASC", Array("EVENT_NAME" => "ALTASIB_REVIEW_ADD"));
if(!($dbEvent->Fetch()))
{
                $langs = CLanguage::GetList(($b=""), ($o=""));
                while($lang = $langs->Fetch())
                {
                                $lid = $lang["LID"];
                                IncludeModuleLangFile(__FILE__, $lid);

                                $et = new CEventType;
                                $et->Add(array(
                                                "LID" => $lid,
                                                "EVENT_NAME" => "ALTASIB_REVIEW_ADD",
                                                "NAME" => GetMessage("ALTASIB_REVIEW_CM_REVIEW_ADD"),
                                                "DESCRIPTION" => GetMessage("ALTASIB_REVIEW_CM_REVIEW_ADD_DESC"),
                                ));

                                $arSites = array();
                                $sites = CSite::GetList(($b=""), ($o=""), Array("LANGUAGE_ID"=>$lid));
                                while ($site = $sites->Fetch())
                                                $arSites[] = $site["LID"];

                                if(count($arSites) > 0)
                                {
                                                $emess = new CEventMessage;
                                                $emess->Add(array(
                                                                "ACTIVE" => "Y",
                                                                "EVENT_NAME" => "ALTASIB_REVIEW_ADD",
                                                                "LID" => $arSites,
                                                                "EMAIL_FROM" => "#EMAIL_FROM#",
                                                                "EMAIL_TO" => "#EMAIL#",
                                                                "BCC" => "",
                                                                "SUBJECT" => GetMessage("ALTASIB_REVIEW_CM_REVIEW_ADD_SUBJECT"),
                                                                "MESSAGE" => GetMessage("ALTASIB_REVIEW_CM_REVIEW_ADD_MESSAGE"),
                                                                "BODY_TYPE" => "text",
                                                ));
                                }
                }
}

$dbEvent = CEventMessage::GetList($b="ID", $order="ASC", Array("EVENT_NAME" => "ALTASIB_REVIEW_ADD_NOTIFY"));
if(!($dbEvent->Fetch()))
{
                $langs = CLanguage::GetList(($b=""), ($o=""));
                while($lang = $langs->Fetch())
                {
                                $lid = $lang["LID"];
                                IncludeModuleLangFile(__FILE__, $lid);

                                $et = new CEventType;
                                $et->Add(array(
                                                "LID" => $lid,
                                                "EVENT_NAME" => "ALTASIB_REVIEW_ADD_NOTIFY",
                                                "NAME" => GetMessage("ALTASIB_REVIEW_CM_REVIEW_ADD_NOTIFY"),
                                                "DESCRIPTION" => GetMessage("ALTASIB_REVIEW_CM_REVIEW_ADD_NOTIFY_DESC"),
                                ));

                                $arSites = array();
                                $sites = CSite::GetList(($b=""), ($o=""), Array("LANGUAGE_ID"=>$lid));
                                while ($site = $sites->Fetch())
                                                $arSites[] = $site["LID"];

                                if(count($arSites) > 0)
                                {
                                                $emess = new CEventMessage;
                                                $emess->Add(array(
                                                                "ACTIVE" => "Y",
                                                                "EVENT_NAME" => "ALTASIB_REVIEW_ADD_NOTIFY",
                                                                "LID" => $arSites,
                                                                "EMAIL_FROM" => "#EMAIL_FROM#",
                                                                "EMAIL_TO" => "#EMAIL#",
                                                                "BCC" => "",
                                                                "SUBJECT" => GetMessage("ALTASIB_REVIEW_CM_REVIEW_ADD_SUBJECT_NOTIFY"),
                                                                "MESSAGE" => GetMessage("ALTASIB_REVIEW_CM_REVIEW_ADD_MESSAGE_NOTIFY"),
                                                                "BODY_TYPE" => "text",
                                                ));
                                }
                }
}
?>