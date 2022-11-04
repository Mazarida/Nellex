<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2017 ALTASIB
 */
use ALTASIB\Review\Internals;
use Bitrix\Main\Loader;

include(GetLangFileName($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/altsib.review/lang/", "/options_user_settings.php"));

if (Loader::includeModule("altasib.review")):
    ClearVars("str_altasib_review_");
    $userData = Internals\UserTable::getRow(array(
        'filter' => array("USER_ID" => $ID)
    ));
    if (!$userData) {
        $arReviewUser['ALLOW_POST'] = "Y";
    }
    if (strlen($strError) > 0) {
        $DB->InitTableVarsForEdit("altasib_review_user", "altasib_review_", "str_altasib_review_");
        $DB->InitTableVarsForEdit("b_user", "altasib_review_", "str_altasib_review_");

        $arReviewUser['ALLOW_POST'] = $str_altasib_review_ALLOW_POST;
        $arReviewUser['MODERATE_POST'] = $str_altasib_review_MODERATE_POST;
    }
    
    ?>
    <input type="hidden" name="profile_module_id[]" value="altasib.review">
    <? if ($USER->IsAdmin()): ?>
    <tr>
        <td width="40%"><?= GetMessage("altasib_review_ALLOW_POST") ?></td>
        <td width="60%">
            <input type="checkbox" name="altasib_review_ALLOW_POST" value="Y" <? if ($userData['ALLOW_POST'] == "Y") {
                echo "checked";
            } ?>></td>
    </tr>
    <tr>
        <td width="40%"><?= GetMessage("altasib_review_MODERATE_POST") ?></td>
        <td width="60%">
            <input type="checkbox" name="altasib_review_MODERATE_POST" value="Y" <? if ($userData['MODERATE_POST'] == "Y") {
                echo "checked";
            } ?>></td>
    </tr>
<? endif; ?>
    <?
endif;