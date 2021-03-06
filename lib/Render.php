<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate;

/**
 * Renders messages and values.
 */
class Render
{
	static private $render_mapping = [

		'NULL' => 'render_null',
		'boolean' => 'render_boolean',
		'array' => 'render_array',
		'object' => 'render_object',

	];

	/**
	 * Renders a message into a string.
	 *
	 * @param Message $message
	 *
	 * @return string
	 */
	static public function render_message(Message $message)
	{
		return strtr($message->format, self::build_replace($message->args));
	}

	/**
	 * Renders value type.
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	static public function render_type($value)
	{
		return gettype($value);
	}

	/**
	 * Renders a value into a string.
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	static public function render_value($value)
	{
		$mapping = self::$render_mapping;
		$type = gettype($value);

		if (isset($mapping[$type]))
		{
			$method = $mapping[$type];
			return static::$method($value);
		}

		if (!is_scalar($value))
		{
			return static::render_other($value);
		}

		return (string) $value;
	}

	/**
	 * Creates replace array.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	static protected function build_replace(array $args)
	{
		$replace = [];

		foreach ($args as $arg => $value)
		{
			$replace['{' . $arg . '}'] = static::render_value($value);
		}

		return $replace;
	}

	/**
	 * Renders `null`.
	 *
	 * @return string
	 */
	static protected function render_null()
	{
		return 'null';
	}

	/**
	 * Renders a boolean.
	 *
	 * @param bool $value
	 *
	 * @return string
	 */
	static protected function render_boolean($value)
	{
		return $value === false ? 'false' : 'true';
	}

	/**
	 * Renders an array.
	 *
	 * @param array $value
	 *
	 * @return string
	 */
	static protected function render_array(array $value)
	{
		return 'array{' . implode(', ', array_keys($value)) . '}';
	}

	/**
	 * Renders an object.
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	static protected function render_object($value)
	{
		return 'instance ' . get_class($value);
	}

	/**
	 * Renders other types.
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	static protected function render_other($value)
	{
		return 'type{' . gettype($value) . '}';
	}
}
