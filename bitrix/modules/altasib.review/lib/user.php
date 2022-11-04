<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2017 ALTASIB
 */
namespace ALTASIB\Review;

use Bitrix\Main\Loader;

Class User
{
    public static function getAvatar($USER_ID, $TYPE = false, $arSize = Array())
    {
        $USER_ID = (int)$USER_ID;
        if ($USER_ID == 0) {
            return false;
        }

        if ($arUser = \CUser::GetByID($USER_ID)->Fetch()) {
            $arRes = Array();
            if (!$TYPE || $TYPE == "user") {
                $TYPE = "user";
                if ((int)$arUser["PERSONAL_PHOTO"] > 0) {
                    $arRes["USER"]["AVATAR_ID"] = $arUser["PERSONAL_PHOTO"];
                }
            }

            if ((!$TYPE || $TYPE == "forum") && Loader::includeModule("forum")) {
                if ($arForumUser = \CForumUser::GetByUSER_ID($USER_ID)) {
                    if ((int)$arForumUser["AVATAR"] > 0) {
                        $arRes["FORUM"]["AVATAR_ID"] = $arForumUser["AVATAR"];
                    }
                }
            }

            if ((!$TYPE || $TYPE == "blog") && Loader::includeModule("forum")) {
                if ($arBlogUser = \CBlogUser::GetByID($USER_ID, BLOG_BY_USER_ID)) {
                    if ((int)$arBlogUser["AVATAR"] > 0) {
                        $arRes["BLOG"]["AVATAR_ID"] = $arBlogUser["AVATAR"];
                    }
                }
            }

            if (count($arRes) > 0) {
                foreach ($arRes as $k => $arID) {
                    if (!isset($arSize) || $arSize["width"] == 0 || $arSize["height"] == 0) {
                        $arSize = Array("width" => 80, "height" => 80);
                    }

                    $arImg = \CFile::ResizeImageGet($arID["AVATAR_ID"], $arSize, BX_RESIZE_IMAGE_PROPORTIONAL);
                    $arRes[$k]["SRC"] = $arImg["src"];
                }
                if ($TYPE) {
                    return $arRes[strtoupper($TYPE)]["SRC"];
                }
                return $arRes;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}