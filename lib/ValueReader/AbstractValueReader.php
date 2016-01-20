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

use ICanBoogie\Validate\ValueReader;

/**
 * Abstract class for value readers.
 */
abstract class AbstractValueReader implements ValueReader
{
	/**
	 * @var mixed
	 */
	protected $source;

	/**
	 * @param mixed $source
	 */
	public function __construct($source)
	{
		$this->source = $source;
	}
}
