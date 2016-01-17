<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\MessageFormatter;

use ICanBoogie\Validate\MessageFormatter;

class BasicMessageFormatter implements MessageFormatter
{
	/**
	 * @inheritdoc
	 */
	public function __invoke($message, array $args)
	{
		$replace = [];

		foreach ($args as $arg => $value)
		{
			$replace['{' . $arg . '}'] = $this->stringify_value($value);
		}

		return strtr($message, $replace);
	}

	/**
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
