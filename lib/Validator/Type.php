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
	 * Mapping for `is_*` and `ctype_*` functions.
	 *
	 * @var array
	 */
	static private $mapping = [

		'is' => [ 'array', 'bool', 'double', 'float', 'int', 'integer', 'long',
			'null', 'numeric', 'object', 'real', 'resource', 'scalar', 'string' ],

		'ctype' => [ 'alnum', 'alpha', 'cntrl', 'digit', 'graph', 'lower',
			'print', 'punct', 'space', 'upper', 'xdigit' ]

	];

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
		$context->message_args[self::PARAM_TYPE] = $type = $context->param(self::PARAM_TYPE);
		$callable = $this->resolve_callable($this->normalize_type($type));

		if ($callable)
		{
			return $callable($value);
		}

		return $value instanceof $type;
	}

	/**
	 * Normalizes type.
	 *
	 * @param string $type
	 *
	 * @return string
	 */
	protected function normalize_type($type)
	{
		$type = strtolower($type);

		if ($type == 'boolean')
		{
			$type = 'bool';
		}

		return $type;
	}

	/**
	 * Resolves callable to validate type.
	 *
	 * @param string $type
	 *
	 * @return string|null
	 */
	protected function resolve_callable($type)
	{
		foreach (self::$mapping as $prefix => $types)
		{
			if (in_array($type, $types))
			{
				return "{$prefix}_{$type}";
			}
		}

		return null;
	}
}
