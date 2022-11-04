<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2017 ALTASIB
 */
namespace ALTASIB\Review\Internals;
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class SubscribeTable extends Main\Entity\DataManager
{
    public static function getTableName()
    {
        return 'altasib_review_subs';
    }

    public static function getMap()
    {
        return array(
            'ELEMENT_ID' => new Main\Entity\IntegerField('ELEMENT_ID', array('validation' => array(__CLASS__, 'validateElementId'))),
            'EMAIL' => new Main\Entity\StringField('EMAIL', array('primary' => true,'validation' => array(__CLASS__, 'validateEmail'))),
        );
    }
    public static function validateElementId()
    {
        return array(
            new Main\Entity\Validator\Range(0)
        );
    }

    public static function validateEmail()
    {
        return array(
            new Main\Entity\Validator\Length(1,255)
        );
    }

    public static function add(array $data)
    {
        if(\ALTASIB\Review\Subscribe::isSubscribe($data['ELEMENT_ID'],$data['EMAIL'])){
            throw new \Exception('alredy');
        }

        return parent::add($data);
    }
}