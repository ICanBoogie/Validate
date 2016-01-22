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
 * Representation of validation errors.
 *
 * @method Message[] offsetGet($index)
 */
class ValidationErrors extends \ArrayObject
{
	/**
	 * Creates a new instance with the specified errors.
	 *
	 * @param array $errors
	 *
	 * @return static
	 */
	static public function from(array $errors)
	{
		return new static($errors);
	}

	/**
	 * Returns a copy of the instance.
	 *
	 * @return array
	 */
	public function to_array()
	{
		return $this->getArrayCopy();
	}

	/**
	 * Clears the instance.
	 *
	 * @return $this
	 */
	public function clear()
	{
		$this->exchangeArray([]);

		return $this;
	}
}
