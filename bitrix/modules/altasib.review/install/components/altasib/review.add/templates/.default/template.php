<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2018 ALTASIB
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
	die();
}

use ALTASIB\Review\Subscribe;
use Bitrix\Main\UI\Extension;

Extension::load("ui.hint");
Extension::load('ui.buttons');

$isHidden = true;
if (strlen($arResult["ERROR_MESSAGE"]) > 0) {
	ShowError($arResult["ERROR_MESSAGE"]);
	$isHidden = false;
}
if ($arParams["NOT_HIDE_FORM"] && $isHidden) {
	$isHidden = false;
}

if (isset($_SESSION["REVIEW_ADD_OK"]) && $_SESSION["REVIEW_ADD_OK"]) {
	ShowNote($arParams["MESSAGE_OK"]);
	unset($_SESSION["REVIEW_ADD_OK"]);
	$isHidden = true;
}
?>
<div>
	<? if ($isHidden): ?>
		<div style="margin: 20px 0 24px 0;" id="review_show_form">
		<a href="javascript:void(0)" class="ui-btn ui-btn-success" onclick="ShowReviewForm();"><? echo strlen($arParams["ADD_TITLE"]) == 0 ? GetMessage("ALTASIB_TP_ADD") : $arParams["ADD_TITLE"] ?></a>
		</div><? endif; ?>
	<div id="review_add_form" style="<? if ($isHidden): ?>display:none;<? endif; ?>">
		<form name="review_add" id="review_add" action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data">
			<?= bitrix_sessid_post() ?>
			<input type="hidden" value="<?= $arParams["ELEMENT_ID"]; ?>" name="ELEMENT_ID">
			<input type="hidden" value="<?= $arResult["arMessage"]["RATING"]; ?>" name="RATING" id="RATING">
			<div class="alx_reviews_block_border">&nbsp;</div>
			<div class="alx_reviews_block">
				<h5><? echo strlen($arParams["ADD_TITLE"]) == 0 ? GetMessage("ALTASIB_TP_ADD") : $arParams["ADD_TITLE"] ?></h5>
				<div class="alx_reviews_form">
					<? if ($arParams['SHOW_VOTE_BLOCK']): ?>
						<div class="alx_reviews_form_vote" id="alx_reviews_form_vote">
							<? if ($arParams['SHOW_MAIN_RATING']): ?>
								<div class="alx_reviews_form_pole_name"><?= GetMessage("ALTASIB_TP_RATING") ?>:</div>
								<div class="alx_reviews_form_vote_items" onmouseout="jsReviewVote.Restore();">
									<?
									for ($i = 1; $i <= 5; $i++):
										$class = "alx_reviews_form_vote_item";

									if ($arResult["arMessage"]["RATING"] > 0 && $i <= $arResult["arMessage"]["RATING"]):
										$class = "alx_reviews_form_vote_item alx_reviews_form_vote_item_sel";
										?>
										<script>
											jsReviewVote.Set(<?=$i?>, 'RATING', 0);
										</script>
									<?
									else: ?>
										<script>
											jsReviewVote.Set(4, 'RATING', 0);
										</script>
									<?
									endif;
									?>
										<div id="altasib_item_vote_0_<?= $i ?>" onmouseover="jsReviewVote.Curr(<?= $i ?>,0)" onmouseout="jsReviewVote.Out(0)" onclick="jsReviewVote.Set(<?= $i ?>,'RATING',0)" class="<?= $class ?>"></div>
									<? endfor; ?>
								</div>

							<? endif; ?>
							<? if (count($arParams["USER_FIELDS_RATING"]) > 0): ?>
								<div class="alx_clear_block">&nbsp;</div>
								<? foreach ($arParams["USER_FIELDS_RATING"] as $FIELD_NAME => $arUserField): ?>
									<div class="alx_reviews_form_pole_name"><? if ($arUserField["MANDATORY"] == "Y"): ?>
											<span class="requred_txt">*</span><? endif; ?> <?= $arUserField["EDIT_FORM_LABEL"] ?>:
									</div>
									<? $APPLICATION->IncludeComponent("bitrix:system.field.edit",
										$arUserField["USER_TYPE"]["USER_TYPE_ID"],
										array("bVarsFromForm" => $arResult, "arUserField" => $arUserField), null,
										array("HIDE_ICONS" => "Y")); ?>
									<div class="alx_clear_block">&nbsp;</div>
								<? endforeach; ?>

							<? endif; ?>
							<div class="alx_clear_block">&nbsp;</div>
						</div>
					<? endif; ?>

					<? if (!$USER->IsAuthorized()): ?>
						<div class="alx_reviews_form_item_pole alx_reviews_form_poles_small">
							<div class="alx_reviews_form_pole_name">
								<span class="requred_txt">*</span> <?= GetMessage("ALTASIB_TP_NAME") ?>:
							</div>
							<div class="alx_reviews_form_inputtext_bg">
								<input type="text" name="AUTHOR_NAME" value="<?= $arResult["arMessage"]["AUTHOR_NAME"]; ?>"/>
							</div>
							<div class="alx_clear_block">&nbsp;</div>
						</div>
						<div class="alx_reviews_form_item_pole alx_reviews_form_poles_small">
							<div class="alx_reviews_form_pole_name">
								<span class="requred_txt">*</span> <?= GetMessage("ALTASIB_TP_EMAIL") ?>:
							</div>
							<div class="alx_reviews_form_inputtext_bg">
								<input type="text" name="AUTHOR_EMAIL" value="<?= $arResult["arMessage"]["AUTHOR_EMAIL"]; ?>"/>
							</div>
							<div class="alx_clear_block">&nbsp;</div>
						</div>
					<? endif; ?>

					<? if ($arParams["ALLOW_TITLE"]): ?>
						<div class="alx_reviews_form_item_pole alx_reviews_form_item_pole_last">
							<div class="alx_reviews_form_pole_name">
								<span class="requred_txt">*</span> <?= GetMessage("ALTASIB_TP_TITLE") ?>:
							</div>
							<div class="alx_reviews_form_inputtext_bg">
								<div class="alx_reviews_form_inputtext_bg_arr"></div>
								<input type="text" name="TITLE" value="<?= $arResult["arMessage"]["TITLE"]; ?>"/></div>
						</div>
						<div class="alx_clear_block">&nbsp;</div>
					<? endif; ?>
					<? if (!$arParams["COMMENTS_MODE"]): ?>
						<div class="alx_reviews_form_item_pole_textarea">
							<div class="alx_reviews_form_pole_name">
								<span class="requred_txt">*</span> <?= GetMessage("ALTASIB_TP_PLUS") ?>:
							</div>
							<div class="alx_reviews_form_textarea_bg">
								<? \ALTASIB\Review\Tools::showLHE("MESSAGE_PLUS",
									$arResult["arMessage"]["MESSAGE_PLUS"], "MESSAGE_PLUS"); ?>
							</div>

						</div>
						<div class="alx_reviews_form_item_pole_textarea">
							<div class="alx_reviews_form_pole_name">
								<span class="requred_txt">*</span> <?= GetMessage("ALTASIB_TP_MINUS") ?>:
							</div>
							<div class="alx_reviews_form_textarea_bg">
								<? \ALTASIB\Review\Tools::showLHE("MESSAGE_MINUS",
									$arResult["arMessage"]["MESSAGE_MINUS"], "MESSAGE_MINUS"); ?>
							</div>

						</div>
					<? endif; ?>
					<div class="alx_reviews_form_item_pole_textarea">
						<div class="alx_reviews_form_pole_name">
							<span class="requred_txt">*</span> <?= GetMessage("ALTASIB_TP_COMMENT") ?>:
						</div>
						<div class="alx_reviews_form_textarea_bg">
							<? \ALTASIB\Review\Tools::showLHE("MESSAGE", $arResult["arMessage"]["MESSAGE"], "MESSAGE",
								200, "oLHErwc"); ?>
						</div>
						<div class="alx_reviews_form_item_pole_textarea_dop_txt">
							<? if ($arParams["MIN_LENGTH"] > 0): ?><?= GetMessage("ALTASIB_TP_MIN_L") ?>
								<span class="alx_reviews_red_txt"><?= $arParams["MIN_LENGTH"] ?></span> <?= GetMessage("ALTASIB_TP_S") ?>.
								<br/><? endif; ?>
							<? if ($arParams["MAX_LENGTH"] > 0): ?><?= GetMessage("ALTASIB_TP_MAX_L") ?> <span class="alx_reviews_red_txt"><?= $arParams["MAX_LENGTH"] ?></span> <?= GetMessage("ALTASIB_TP_S") ?>.<? endif; ?>
						</div>

						<? if ($arParams["ALLOW_UPLOAD_FILE"]):
							$APPLICATION->IncludeComponent("bitrix:main.file.input", "", Array(
								"ALLOW_UPLOAD" => "F",
								"ALLOW_UPLOAD_EXT" => $arParams["UPLOAD_FILE_TYPE"],
								"MAX_FILE_SIZE" => $arParams["UPLOAD_FILE_SIZE"] * 1024,
								"INPUT_NAME" => "FILES",
								"INPUT_NAME_UNSAVED" => "FILES_TMP",
								"MULTIPLE" => "Y",
								"MODULE_ID" => "altasib.review",
								'CONTROL_ID' => 'reviewFileAdd'
							));
							?>

						<? endif; ?>

						<div class="alx_clear_block">&nbsp;</div>
					</div>

					<? if (count($arParams["USER_FIELDS"]) > 0): ?>
						<div class="alx_reviews_form_poles_group">
							<div class="alx_reviews_form_poles_group_border_top">&nbsp;</div>
							<? foreach ($arParams["USER_FIELDS"] as $FIELD_NAME => $arUserField): ?>
								<div class="alx_reviews_form_item_pole_uf">
									<div class="alx_reviews_form_pole_name"><? if ($arUserField["MANDATORY"] == "Y"): ?>
											<span class="requred_txt">*</span><? endif; ?> <?= $arUserField["EDIT_FORM_LABEL"] ?>:
									</div>
									<?
									if ($arUserField["USER_TYPE"]["USER_TYPE_ID"] == "string_formatted") {
										$classUF = "alx_reviews_form_textarea_bg";
									} elseif ($arUserField["USER_TYPE"]["USER_TYPE_ID"] == "ALTASIB_REVIEW_RATING") {
										$classUF = "alx_reviews_form_field_vote";
									} else {
										$classUF = "alx_reviews_form_field";
									}
									?>
									<div class="<?= $classUF ?>">
										<? $APPLICATION->IncludeComponent("bitrix:system.field.edit",
											$arUserField["USER_TYPE"]["USER_TYPE_ID"],
											array("bVarsFromForm" => $arResult, "arUserField" => $arUserField), null,
											array("HIDE_ICONS" => "Y"));
										?>
									</div>
									<div class="alx_clear_block"></div>
								</div>

							<? endforeach; ?>
							<div class="alx_reviews_form_poles_group_border_bottom">&nbsp;</div>
						</div>
					<? endif; ?>

					<? if ($arParams["USE_CAPTCHA"] == "Y"): ?>
						<div class="alx_reviews_form_captcha">
							<div class="alx_reviews_form_pole_name">
								<span class="requred_txt">*</span> <?= GetMessage('ALTASIB_TP_CONFIRM') ?>
							</div>
							<div class="alx_reviews_form_captcha_pole">
								<div class="alx_reviews_form_inputtext_bg"><input type="text" name="captcha_word"/>
								</div>
							</div>
							<div class="alx_reviews_form_captcha_pic">
								<input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
								<div class="alx_reviews_form_captcha_pic_block">
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="116" height="37" alt="CAPTCHA" id="alx_review_CAPTCHA"/>
								</div>
								<a href="javascript:void(0);" onclick="BX('alx_review_CAPTCHA').src=BX('alx_review_CAPTCHA').src+'&rnd='+Math.random()"><?= GetMessage("ALTASIB_TP_RELOAD") ?></a>
							</div>
							<div class="alx_clear_block">&nbsp;</div>
						</div>
					<? endif; ?>
					<div class="alx_clear_block">&nbsp;</div>
					<? if (!Subscribe::isSubscribe($arParams["ELEMENT_ID"], $USER->GetEmail())): ?>
					<div class="alx_reviews_subscribe">
						<label><input type="checkbox" name="SUBSCRIBE" value="Y" <? if ($arResult["arMessage"]['SUBSCRIBE'] == 'Y'): ?>checked="checked"<? endif; ?>/>
							<?= GetMessage("ALTASIB_TP_SUBSCRIBE") ?></label></div>
				</div>
				<? endif; ?>
			</div>
			<div class="alx_reviews_block_border"></div>
			<div style="padding: 15px 15px 15px 15px;">
				<?if ($arParams['USER_CONSENT'] == 'Y' && !$USER->IsAuthorized()):?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.userconsent.request",
						"",
						array(
							"ID" => $arParams["USER_CONSENT_ID"],
							"IS_CHECKED" => $arParams["USER_CONSENT_IS_CHECKED"],
							"AUTO_SAVE" => "Y",
							"IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
							"REPLACE" => array(
								'button_caption' => GetMessage("ALTASIB_TP_SEND"),
								'fields' => array(GetMessage("ALTASIB_TP_S_NAME"),GetMessage("ALTASIB_TP_S_EMAIL"))
							),
						)
					);?>
				<?endif;?>
			</div>

			<div class="alx_reviews_form_submit_block">
				<div style="padding-left: 10px">
					<input type="submit" class="ui-btn ui-btn-success" name="review_add_btn" value="<?= GetMessage("ALTASIB_TP_SEND") ?>"/>
				</div>
			</div>
	</div>
	</form>
</div>