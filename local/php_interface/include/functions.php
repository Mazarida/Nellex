<?
use Bitrix\Highloadblock\HighloadBlockTable as HL;

/**
 * Функция распечатки массива
 * @var $var - переменная для распечатки
 * @var bool $all - разрешена ли распечатка остальным пользователям (не считая админа)
 * @var bool $die - прекратить дальнейшую работу скриптов после распечатки
 */
function PR($var, $all = false, $die = false)
{
    global $USER;
    if(($USER->GetID() == 1) || ($all == true)) {
        $bt =  debug_backtrace();
        $bt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        ?>
        <div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;'>
            <div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?=$bt["file"]?> [<?=$bt["line"]?>]</div>
            <pre style='padding:10px;'><?print_r($var)?></pre>
        </div>
    <?
    }
    if($die) {
        die;
    }
}

function GetEntityDataClass($HlBlockId)
{
    if (\Bitrix\Main\Loader::includeModule('highloadblock')) {
        if (empty($HlBlockId) || $HlBlockId < 1) {
            return false;
        }
        $hlblock = HL::getById($HlBlockId)->fetch();
        $entity = HL::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        return $entity_data_class;
    }

    return false;
}
