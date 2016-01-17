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
 * Representation of an error message.
 */
class Message
{
	/**
	 * Message pattern.
	 *
	 * @var string
	 */
	public $message;

	/**
	 * Formatting arguments.
	 *
	 * @var array
	 */
	public $args;

	/**
	 * @param string $message
	 * @param array $args
	 */
	public function __construct($message, array $args = [])
	{
		$this->message = $message;
		$this->args = $args;
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return strtr($this->message, $this->create_replace($this->args));
	}

	/**
	 * Creates replace array.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	protected function create_replace(array $args)
	{
		$replace = [];

		foreach ($args as $arg => $value)
		{
			$replace['{' . $arg . '}'] = $this->stringify_value($value);
		}

		return $replace;
	}

	/**
	 * Stringify a value.
	 *
	 * @param mixed $value
	 *
	 * @return string
	 */
	protected function stringify_value($value)
	{
		if ($value === null)
		{
			return 'null';
		}

		if ($value === false)
		{
			return 'false';
		}

		if ($value === true)
		{
			return 'true';
		}

		if (is_array($value))
		{
			return 'array{' . implode(', ', array_keys($value)) . '}';
		}

		if (is_object($value))
		{
			return 'instance ' . get_class($value);
		}

		if (!is_scalar($value))
		{
			return 'type{' . gettype($value) . '}';
		}

		return $value;
	}
}
