<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\ValueReader;

/**
 * Value reader for `$_GET`, `$_POST`, or `$_REQUEST`.
 */
class RequestValueReader extends ArrayValueReader
{
	/**
	 * If a value is a string and once trimed is empty `null` is returned.
	 *
	 * @inheritdoc
	 */
	public function read($name)
	{
		$value = parent::read($name);

		if (is_string($value) && trim($value) === '')
		{
			return null;
		}

		return $value;
	}
}
