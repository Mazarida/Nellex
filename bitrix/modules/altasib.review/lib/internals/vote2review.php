<?php
/**
 * ALTASIB
 * @site http://www.altasib.ru
 * @email dev@altasib.ru
 * @copyright 2006-2018 ALTASIB
 */

namespace ALTASIB\Review\Internals;

use \Bitrix\Main;
use \Bitrix\Main\Entity;
use ALTASIB\Review\Tools;

class Vote2ReviewTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'altasib_review_vote_to_review';
	}

	public static function getMap()
	{
		return array(
			'TIMESTAMP_X' => array(
				'data_type' => 'datetime'
			),

			'USER_ID' => array(
				'data_type' => 'integer'
			),

			'REVIEW_ID' => array(
				'data_type' => 'integer',
				'primary' => true,
			),
			'IP' => array(
				'data_type' => 'string'
			)
		);
	}
}