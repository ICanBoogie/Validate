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

use ICanBoogie\Validate\AbstractValueReader;

class ArrayValueReader extends AbstractValueReader
{
	/**
	 * @inheritdoc
	 */
	protected function raw_read($name)
	{
		return isset($this->source[$name]) ? $this->source[$name]: null;
	}
}
