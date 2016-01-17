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

use ICanBoogie\Validate\Validator\ParameterIsMissing;

/**
 * Representation of a validation context.
 */
class Context
{
	/**
	 * The attribute being validated.
	 *
	 * @var string
	 */
	public $attribute;

	/**
	 * The value being validated.
	 *
	 * @var mixed
	 */
	public $value;

	/**
	 * The current validator.
	 */
	public $validator;

	/**
	 * The validator options.
	 *
	 * @var array
	 */
	public $options = [];

	/**
	 * @var ValueReader
	 */
	public $values;

	/**
	 * Possible error message.
	 *
	 * @var string
	 */
	public $message;

	/**
	 * Arguments for the possible error message.
	 */
	public $message_args = [];

	/**
	 * The collected errors.
	 *
	 * @var
	 */
	public $errors = [];

	/**
	 * Retrieves a parameter from the options.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 *
	 * @throws ParameterIsMissing if the parameter is not set.
	 */
	public function param($name)
	{
		if (!isset($this->options[$name]))
		{
			throw new ParameterIsMissing(get_class($this->validator) . '::PARAM_' . strtoupper($name));
		}

		return $this->options[$name];
	}

	/**
	 * Retrieves an options from the options.
	 *
	 * @param string $name
	 * @param mixed|null $default
	 *
	 * @return mixed|null The option value or `null` if it is not defined.
	 */
	public function option($name, $default = null)
	{
		if (!isset($this->options[$name]))
		{
			return $default;
		}

		return $this->options[$name];
	}
}
