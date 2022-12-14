<?php

namespace Bitrix\Mail\Controller;

use Bitrix\Mail\Internals\Entity\UserSignature;
use Bitrix\Mail\Internals\UserSignatureTable;
use Bitrix\Main\Engine\Binder;
use Bitrix\Main\Engine\Controller;

abstract class Base extends Controller
{
	protected function init()
	{
		parent::init();

		Binder::registerParameterDependsOnName(
			UserSignature::class,
			function($className, $id)
			{
				return UserSignatureTable::getById($id)->fetchObject();
			}
		);
	}

	/**
	 * @param array $array
	 * @param int $levels
	 * @param int $currentLevel
	 * @return array
	 */
	protected function convertArrayKeysToCamel(array $array, $levels = 0, $currentLevel = 0)
	{
		$result = [];
		foreach($array as $key => $value)
		{
			if($levels > 0 && is_array($value) && $currentLevel < $levels)
			{
				$currentLevel++;
				$value = $this->convertArrayKeysToCamel($value, $levels, $currentLevel);
				$currentLevel--;
			}
			$result[$this->toCamelCase($key)] = $value;
		}

		return $result;
	}

	/**
	 * @param array $array
	 * @param int $levels
	 * @param int $currentLevel
	 * @return array
	 */
	protected function convertArrayKeysToUpper(array $array, $levels = 0, $currentLevel = 0)
	{
		$result = [];
		foreach($array as $key => $value)
		{
			if($levels > 0 && is_array($value) && $currentLevel < $levels)
			{
				$currentLevel++;
				$value = $this->convertArrayKeysToUpper($value, $levels, $currentLevel);
				$currentLevel--;
			}
			$result[$this->toUpperCase($key)] = $value;
		}

		return $result;
	}

	/**
	 * @param string $string
	 * @return string
	 */
	protected function toCamelCase($string)
	{
		if(is_numeric($string))
		{
			return $string;
		}
		$string = str_replace('_', ' ', strtolower($string));
		return lcfirst(str_replace(' ', '', ucwords($string)));
	}

	/**
	 * @param string $string
	 * @return string
	 */
	protected function toUpperCase($string)
	{
		if(is_numeric($string))
		{
			return $string;
		}
		return strtoupper(preg_replace('/(.)([A-Z])/', '$1_$2', $string));
	}
}