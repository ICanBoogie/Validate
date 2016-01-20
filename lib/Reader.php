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
 * An interface to read values from a source.
 */
interface Reader
{
	/**
	 * Reads a value from a source.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function read($name);
}
