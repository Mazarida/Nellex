<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2017 ALTASIB
 */
namespace ALTASIB\Review\Internals;

use Bitrix\Main\Entity;

Class UserTable extends Entity\DataManager
{
    public static function getFilePath()
    {
        return __FILE__;
    }

    public static function getTableName()
    {
        return 'altasib_review_user';
    }

    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
            ),
            'USER_ID' => array(
                'data_type' => 'integer'
            ),
            'USER' => array(
                'data_type' => 'Bitrix\Main\User',
                'reference' => array('=this.USER_ID' => 'ref.ID')
            ),
            'ALLOW_POST' => array(
                'data_type' => 'boolean',
                'values' => array('N', 'Y')
            ),
            'MODERATE_POST' => array(
                'data_type' => 'boolean',
                'values' => array('N', 'Y')
            )
        );
    }
}