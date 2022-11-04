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

class ReviewTable extends Entity\DataManager
{
	public static function getFilePath()
	{
		return __FILE__;
	}

	public static function getTableName()
	{
		return 'altasib_review';
	}

	public static function getUfId()
	{
		return 'ALTASIB_REVIEW';
	}

	public static function getMap()
	{
		global $DB;
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
			),
			'ELEMENT_ID' => array(
				'data_type' => 'integer'
			),

			'APPROVED' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y')
			),
			'USER_ID' => array(
				'data_type' => 'integer'
			),

			'USER' => array(
				'data_type' => 'Bitrix\Main\User',
				'reference' => array('=this.USER_ID' => 'ref.ID')
			),
			'SITE_ID' => array(
				'data_type' => 'string'
			),
			'AUTHOR_ID' => array(
				'data_type' => 'integer'
			),
			'AUTHOR_NAME' => array(
				'data_type' => 'string'
			),
			'AUTHOR_EMAIL' => array(
				'data_type' => 'string'
			),
			'AUTHOR_IP' => array(
				'data_type' => 'string'
			),
			'POST_DATE' => array(
				'data_type' => 'datetime',
			),
			'DATE' => array(
				'data_type' => 'datetime',
				'expression' => array(
					str_replace('%%ss', '%s', str_replace('%', '%%', $DB->DateToCharFunction('%ss', 'FULL'))),
					'POST_DATE'
				)
			),
			'MESSAGE_PLUS' => array(
				'data_type' => 'string'
			),
			'MESSAGE_PLUS_HTML' => array(
				'data_type' => 'string'
			),
			'MESSAGE_MINUS' => array(
				'data_type' => 'string'
			),
			'MESSAGE_MINUS_HTML' => array(
				'data_type' => 'string'
			),
			'MESSAGE' => array(
				'data_type' => 'string'
			),
			'MESSAGE_HTML' => array(
				'data_type' => 'string'
			),
			'TITLE' => array(
				'data_type' => 'string'
			),
			'REPLY' => array(
				'data_type' => 'string'
			),
			'REPLY_HTML' => array(
				'data_type' => 'string'
			),
			'IS_SEND' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y')
			),
			'VOTE_MINUS' => array(
				'data_type' => 'integer'
			),
			'VOTE_PLUS' => array(
				'data_type' => 'integer'
			),
			'RATING' => array(
				'data_type' => 'integer'
			),
			'ONLY_RATING' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y')
			),
			'IS_BEST' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y')
			),
			'CNT' => array('expression' => array('COUNT(*)'), 'data_type' => 'integer'),
			'VOTE' => array('expression' => array('(%s) - (%s)', 'VOTE_PLUS', 'VOTE_MINUS'), 'data_type' => 'integer')
		);
	}

	public static function count($filter)
	{
		$data = self::getList(array('filter' => $filter, 'select' => array('CNT')));
		if ($result = $data->fetch()) {
			return $result['CNT'];
		}
		return 0;
	}

	public static function update($ID, $data)
	{
		$res = parent::update($ID, $data);
		if ($res->isSuccess()) {
			Tools::clearCacheFull($ID);
		}
		return $res;
	}

	public static function deleteByElement($ID)
	{
		$ob = self::getList(array(
			'filter' => array('ELEMENT_ID' => $ID),
			'select' => array('ID')
		));
		while ($data = $ob->fetch()) {
			self::delete($data['ID']);
		}
	}

	public static function delete($ID)
	{
		if ($data = self::getRow(array(
			'filter' => array('ID' => $ID),
			'select' => array('ID', 'ELEMENT_ID', 'USER_ID', 'AUTHOR_IP')
		))
		) {
			Vote2ReviewTable::delete($data["ID"]);

			$r2eIterator = Rating2ElementTable::query()
				->where('ELEMENT_ID', '=', $data["ELEMENT_ID"])
				->where(Entity\Query::filter()
					->logic('or')
					->where('USER_ID', '=', $data["USER_ID"])
					->where('IP', '=', $data['AUTHOR_IP']))
				->addSelect('ID')
				->exec();

			while ($r2eData = $r2eIterator->fetch()) {
				Rating2ElementTable::delete($r2eData['ID']);
			}
			$GLOBALS["USER_FIELD_MANAGER"]->Delete("ALTASIB_REVIEW", $ID);
			if (Main\Loader::includeModule("search") && \COption::GetOptionString("altasib.review", "indexing",
					"Y") == "Y"
			) {
				\CSearch::DeleteIndex("altasib.review", $ID);
			}
			FileTable::deleteByReview($ID);
			parent::delete($ID);
			Tools::clearCache($data['ELEMENT_ID']);
		}
	}
}