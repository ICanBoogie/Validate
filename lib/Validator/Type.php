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
 * Validates that a value is null.
 */
class Type extends AbstractValidator
{
	const ALIAS = 'type';
	const DEFAULT_MESSAGE = "should be of type {type}";

	const PARAM_TYPE = 'type';

	/**
	 * @inheritdoc
	 */
	public function normalize_options(array $options)
	{
		if (isset($options[0]))
		{
			$options[self::PARAM_TYPE] = $options[0];
		}

		return $options;
	}

	/**
	 * @inheritdoc
	 */
	public function validate($value, callable $error, Context $context)
	{
		$original_type = $context->param(self::PARAM_TYPE);
		$type = strtolower($original_type);

		if ($type == 'boolean')
		{
			$type = 'bool';
		}

		$is_function = 'is_' . $type;
		$ctype_function = 'ctype_' . $type;

		if (function_exists($is_function) && $is_function($value))
		{
			return;
		}
		elseif (function_exists($ctype_function) && $ctype_function($value))
		{
			return;
		}
		elseif ($value instanceof $original_type)
		{
			return;
		}

		$error(null, [

			self::PARAM_TYPE => $original_type

		]);
	}
}
