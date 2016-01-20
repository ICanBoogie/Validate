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
 * Value reader for an array or an instance of {@link ArrayAccess}.
 */
class ArrayValueReader extends AbstractValueReader
{
	/**
	 * If the offset does not exists `null` is returned.
	 *
	 * @inheritdoc
	 */
	public function read($name)
	{
		return isset($this->source[$name]) ? $this->source[$name] : null;
	}
}
