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
	static private $render_mapping = [

		'NULL' => 'render_null',
		'boolean' => 'render_boolean',
		'array' => 'render_array',
		'object' => 'render_object',

	];

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
		$mapping = self::$render_mapping;
		$type = gettype($value);

		if (isset($mapping[$type]))
		{
			return $this->{ $mapping[$type] }($value);
		}

		if (!is_scalar($value))
		{
			return $this->render_other($value);
		}

		return (string) $value;
	}

	/**
	 * Renders `null`.
	 *
	 * @return string
	 */
	protected function render_null()
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
	protected function render_boolean($value)
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
	protected function render_array(array $value)
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
	protected function render_object($value)
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
	protected function render_other($value)
	{
		return 'type{' . gettype($value) . '}';
	}
}
