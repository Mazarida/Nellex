<?
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2017 ALTASIB
 */
IncludeModuleLangFile(__FILE__);
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php");

CModule::IncludeModule("altasib.review");
$GROUP_RIGHT = $APPLICATION->GetGroupRight("altasib.review");
if($GROUP_RIGHT<"W")
        return;

$module_id = "altasib.review";
$strWarning = "";

$arAllOptions = array(
                "main" => Array(
                    Array("not_moderate", GetMessage("ALTASIB_REVIEW_NO_MOD"), "N", Array("checkbox", "Y")),
                    Array("transfer", GetMessage("ALTASIB_REVIEW_TRANSFER"), "5", Array("text", "25"),'',GetMessage("ALTASIB_REVIEW_TRANSFER_NOTE")),
                    Array("email_from", GetMessage("ALTASIB_REVIEW_EMAIL_FROM"), COption::GetOptionString("main", "email_from"), Array("text", "25")),
                    Array("email_admin", GetMessage("ALTASIB_REVIEW_EMAIL_ADMIN"), COption::GetOptionString("main", "email_from"), Array("text", "25")),
                    Array("ninf", GetMessage("ALTASIB_REVIEW_NO_INDEX"), "Y", Array("checkbox", "Y")),
					Array("npcw", GetMessage("ALTASIB_REVIEW_NOT_PUBLISH_IF_HAVE_WORDS"), "", Array("textarea", "10",50)),
					Array("indexing", GetMessage("ALTASIB_REVIEW_OPTIONS_SEARCH_INDEX"), "Y", Array("checkbox", "Y")),
                ),
                "VOTE" => Array(
                    Array("VOTE_SESION", GetMessage("ALTASIB_REVIEW_OPTIONS_VOTE_PARAMS_SESSION").":", "N", Array("checkbox")),
                    Array("VOTE_COOKIE", GetMessage("ALTASIB_REVIEW_OPTIONS_VOTE_PARAMS_COOKIE").":", "N", Array("checkbox")),
                    Array("VOTE_IP", GetMessage("ALTASIB_REVIEW_OPTIONS_VOTE_PARAMS_IP").":", "N", Array("checkbox")),
                    Array("VOTE_USER_ID", GetMessage("ALTASIB_REVIEW_OPTIONS_VOTE_PARAMS_USER_ID").":", "Y", Array("checkbox")),
                ),
                "ALLOW_TAGS" => Array(
                    Array("FORM_ALLOW_ALIGN", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_ALIGN").":", "Y", Array("checkbox")),
                    Array("FORM_ALLOW_BIU", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_BIU").":", "Y", Array("checkbox")),
                    Array("FORM_ALLOW_FONT", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_FONT").":", "N", Array("checkbox")),
                    Array("FORM_ALLOW_QUOTE", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_QUOTE").":", "Y", Array("checkbox")),
                    Array("FORM_ALLOW_CODE", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_CODE").":", "N", Array("checkbox")),
                    Array("FORM_ALLOW_ANCHOR", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_ANCHOR").":", "Y", Array("checkbox")),
                    Array("FORM_ALLOW_IMG", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_IMG").":", "Y", Array("checkbox")),
                    Array("FORM_ALLOW_TABLE", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_TABLE").":", "N", Array("checkbox")),
                    Array("FORM_ALLOW_LIST", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_LIST").":", "Y", Array("checkbox")),
                    Array("FORM_ALLOW_NL2BR", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_NL2BR").":", "Y", Array("checkbox")),
                    Array("FORM_ALLOW_VIDEO", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_VIDEO").":", "N", Array("checkbox")),
                    Array("FORM_ALLOW_SMILE", GetMessage("ALTASIB_REVIEW_OPTIONS_FORM_ALLOW_SMILE").":", "N", Array("checkbox")),
                ),        
);
$aTabs = array(
        array("DIV" => "edit1", "TAB" => GetMessage("MAIN_TAB_SET"), "TITLE" => GetMessage("MAIN_TAB_TITLE_SET")),
        array("DIV" => "edit2", "TAB" => GetMessage("MAIN_TAB_RIGHTS"), "ICON" => "ALTASIB_REVIEW_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_RIGHTS")),
);

//Restore defaults
if ($USER->IsAdmin() && $_SERVER["REQUEST_METHOD"]=="GET" && strlen($RestoreDefaults)>0 && check_bitrix_sessid())
{
                COption::RemoveOption("altasib.review");
}
$tabControl = new CAdminTabControl("tabControl", $aTabs);

function ShowParamsHTMLByArray($arParams)
{
                foreach($arParams as $Option)
                {
                        __AdmSettingsDrawRow("altasib.review", $Option);
                }
}

//Save options
if($REQUEST_METHOD=="POST" && strlen($Update.$Apply.$RestoreDefaults)>0 && check_bitrix_sessid())
{
                if(strlen($RestoreDefaults)>0)
                {
                                COption::RemoveOption("altasib.review");
                }
                else
                {
						foreach($arAllOptions as $aOptGroup)
						{
							foreach($aOptGroup as $option)
							{						
								__AdmSettingsSaveOption($module_id, $option);
							}
						}
                }
				COption::SetOptionString($module_id, "GROUP_DEFAULT_RIGHT", $GROUP_DEFAULT_RIGHT, "Right for groups by default");
				reset($arGROUPS);
				while (list(, $value) = each($arGROUPS))
				{
					   $rt = ${"RIGHTS_".$value["ID"]};
					   if (strlen($rt) > 0 && $rt != "NOT_REF")
							   $APPLICATION->SetGroupRight($module_id, $value["ID"], $rt);
					   else
							   $APPLICATION->DelGroupRight($module_id, array($value["ID"]));
				}

				if($_REQUEST["back_url_settings"] <> "" && $_REQUEST["Apply"] == "")
					   echo '<script type="text/javascript">window.location="'.CUtil::addslashes($_REQUEST["back_url_settings"]).'";</script>';				
}
?>

<form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsEx($mid)?>&amp;lang=<?echo LANG?>">
<?
$tabControl->Begin();
$tabControl->BeginNextTab();
                ?>
                <?
                ShowParamsHTMLByArray($arAllOptions["main"]);
                ?>
                <tr class="heading">
                                <td colspan="2" valign="top" align="center"><?echo GetMessage("ALTASIB_REVIEW_VOTE") ?></td>
                </tr>
                <?
                ShowParamsHTMLByArray($arAllOptions["VOTE"]);
                ?>
                
                <tr class="heading">
                                <td colspan="2" valign="top" align="center"><?echo GetMessage("ALTASIB_REVIEW_ALLOW_TAGS") ?></td>
                </tr>
                <?
                ShowParamsHTMLByArray($arAllOptions["ALLOW_TAGS"]);
                ?>
<?$tabControl->BeginNextTab();?>
<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
<?$tabControl->Buttons();?>
<script language="JavaScript">
function RestoreDefaults()
{
                if(confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>'))
                                window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?echo LANG?>&mid=<?echo urlencode($mid)?>&<?=bitrix_sessid_get()?>";
}
</script>
<div align="left">
                <input type="hidden" name="Update" value="Y">
                <input type="submit" <?if(!$USER->IsAdmin())echo " disabled ";?> name="Update" value="<?echo GetMessage("MAIN_SAVE")?>">
                <input type="reset" <?if(!$USER->IsAdmin())echo " disabled ";?> name="reset" value="<?echo GetMessage("MAIN_RESET")?>">
                <input type="button" <?if(!$USER->IsAdmin())echo " disabled ";?>  type="button" title="<?echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>" OnClick="RestoreDefaults();" value="<?echo GetMessage("MAIN_RESTORE_DEFAULTS")?>">
</div>
<?$tabControl->End();?>
<?=bitrix_sessid_post();?>
</form>