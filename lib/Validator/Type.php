<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is of a specified type.
 */
class Type extends AbstractValidator
{
	const ALIAS = 'type';
	const DEFAULT_MESSAGE = "should be of type {type}";

	const PARAM_TYPE = 'type';

	/**
	 * @inheritdoc
	 */
	public function normalize_params(array $params)
	{
		if (isset($params[0]))
		{
			$params[self::PARAM_TYPE] = $params[0];
		}

		return $params;
	}

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		$context->message_args[self::PARAM_TYPE] = $original_type = $context->param(self::PARAM_TYPE);

		$type = strtolower($original_type);

		if ($type == 'boolean')
		{
			$type = 'bool';
		}

		$is_function = 'is_' . $type;

		if (function_exists($is_function) && $is_function($value))
		{
			return true;
		}

		$ctype_function = 'ctype_' . $type;

		if (function_exists($ctype_function) && $ctype_function($value))
		{
			return true;
		}

		if ($value instanceof $original_type)
		{
			return true;
		}

		return false;
	}
}
