<?
define("BX_USE_MYSQLI", true);
define("DBPersistent", false);
$DBType = "mysql";
$DBHost = "sqlnew.101bot.ru";
$DBLogin = "toaster_t16nelx";
$DBPassword = "a48d1347f";
$DBName = "toaster_t16nelx";
$DBDebug = false;
$DBDebugToFile = false;

define("DELAY_DB_CONNECT", true);
define("CACHED_b_file", 3600);
define("CACHED_b_file_bucket_size", 10);
define("CACHED_b_lang", 3600);
define("CACHED_b_option", 3600);
define("CACHED_b_lang_domain", 3600);
define("CACHED_b_site_template", 3600);
define("CACHED_b_event", 3600);
define("CACHED_b_agent", 3660);
define("CACHED_menu", 3600);

define("BX_UTF", true);
define("BX_FILE_PERMISSIONS", 0644);
define("BX_DIR_PERMISSIONS", 0755);
@umask(~(BX_FILE_PERMISSIONS|BX_DIR_PERMISSIONS)&0777);
define("BX_DISABLE_INDEX_PAGE", true);

function getAllCountr(){
    $return = 0;

    $dbBasketItems = CSaleBasket::GetList(false, array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "DELAY" => "N"), false, false, array("ID","QUANTITY", "PRICE"));
    while ($arItems = $dbBasketItems->Fetch())
        $return   +=   $arItems['QUANTITY'];

    return $return;
}
?>