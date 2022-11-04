<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$APPLICATION->SetTitle("nellex.shop");
?>

    <div class="content__wrapper-home">
        <div class="sc1__slider-swip">
            <?
            $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => SITE_DIR."include/main_page/main_slider.php",
                "EDIT_TEMPLATE" => ""
            ),
                false,
                array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => "")
            );
            ?>
        </div>

        <div class="sc2__banner-group">
            <?
            $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => SITE_DIR."include/main_page/main_banners.php",
                "EDIT_TEMPLATE" => ""
            ),
                false,
                array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => "")
            );
            ?>
        </div>

        <div class="sc3__igs-holder">
            <div class="flex-row sc3__ig-row">
                <?$APPLICATION->IncludeFile(SITE_DIR."/include/main_page/testimonials.php", Array(), Array("MODE" => "html"));?>
            </div>
        </div>

        <div class="sc4__hits-section">
            <div class="sc4__head-hits"><?$APPLICATION->IncludeFile(SITE_DIR."/include/main_page/hits_title.php", Array(), Array("MODE" => "text"));?></div>
            <?$APPLICATION->IncludeFile(SITE_DIR."/include/main_page/hits_link.php", Array(), Array("MODE" => "html"));?>
                <?
                $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => SITE_DIR."include/main_page/bestsellers.php",
                    "EDIT_TEMPLATE" => ""
                ),
                    false,
                    array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => "")
                );
                ?>
        </div>

        <div class="sc5__brands-about">
            <?
            $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => SITE_DIR."include/main_page/brands_about.php",
                "EDIT_TEMPLATE" => ""
            ),
                false,
                array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => "")
            );
            ?>
        </div>

        <div class="gap__white"></div>

        <div class="sc6__collage-holder">
            <div class="flex-row sc6__collage">
                <div class="sc5__collage-cl1">
                    <div class="flex-row sc5__cl1-r1">
                        <div class="sc5__img-cl im-nell" style="background-image: url('<?$APPLICATION->IncludeFile(SITE_DIR.
                            "/include/main_page/collage_1_image.php", Array(), Array("MODE" => "html"));?>')"></div>
                        <div class="sc5__cl-clg">
                            <?$APPLICATION->IncludeFile(SITE_DIR."/include/main_page/collage_1.php", Array(), Array("MODE" => "html"));?>
                        </div>
                    </div>
                    <div class="flex-row sc5__cl1-r2">
                        <div class="sc5__cl-clg">
                            <?$APPLICATION->IncludeFile(SITE_DIR."/include/main_page/collage_2.php", Array(), Array("MODE" => "html"));?>
                        </div>
                        <div class="sc5__img-cl im-regarzo" style="background-image: url('<?$APPLICATION->IncludeFile(SITE_DIR.
                            "/include/main_page/collage_2_image.php", Array(), Array("MODE" => "html"));?>')"></div>
                    </div>
                </div>
                <div class="sc5__collage-cl2 im-vilermo" style="background-image: url('<?$APPLICATION->IncludeFile(SITE_DIR.
                    "/include/main_page/collage_3_image.php", Array(), Array("MODE" => "html"));?>')">
                    <?$APPLICATION->IncludeFile(SITE_DIR."/include/main_page/collage_3.php", Array(), Array("MODE" => "html"));?>
                </div>
            </div>
        </div>

        <div class="sc7__insta-w">
            <div class="sc7__hashtag"><?$APPLICATION->IncludeFile(SITE_DIR."/include/main_page/insta_widget_title.php", Array(), Array("MODE" => "text"));?></div>
            <?
            $APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => SITE_DIR."include/inwidget/index.php",
                "EDIT_TEMPLATE" => ""
            ),
                false,
                array("HIDE_ICONS"=>"Y", "ACTIVE_COMPONENT" => "")
            );
            ?>
        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>