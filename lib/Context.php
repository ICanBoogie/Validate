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
	 * The value of the attribute being validated.
	 *
	 * @var mixed
	 */
	public $value;

	/**
	 * A reader adapter.
	 *
	 * @var Reader
	 */
	public $reader;

	/**
	 * The current validator.
	 *
	 * @var Validator
	 */
	public $validator;

	/**
	 * The validator parameters.
	 *
	 * @var array
	 */
	public $validator_params = [];

	/**
	 * The possible error message for the current validator.
	 *
	 * @var string
	 */
	public $message;

	/**
	 * The arguments for the possible error message.
	 *
	 * @var array
	 */
	public $message_args = [];

	/**
	 * The collected errors.
	 *
	 * @var Message[][]
	 */
	public $errors = [];

	/**
	 * Retrieves a value from the reader adapter.
	 *
	 * @param string $name
	 *
	 * @return mixed|null The value, or `null` if it is not defined.
	 */
	public function value($name)
	{
		return $this->reader->read($name);
	}

	/**
	 * Retrieves a parameter from the validator parameters.
	 *
	 * @param string $name
	 *
	 * @return mixed
	 *
	 * @throws ParameterIsMissing if the parameter is not set.
	 */
	public function param($name)
	{
		if (!isset($this->validator_params[$name]))
		{
			throw new ParameterIsMissing(get_class($this->validator) . '::PARAM_' . strtoupper($name));
		}

		return $this->validator_params[$name];
	}

	/**
	 * Retrieves an option from the validator parameters.
	 *
	 * @param string $name
	 * @param mixed|null $default
	 *
	 * @return mixed|null The option value or `null` if it is not defined.
	 */
	public function option($name, $default = null)
	{
		return isset($this->validator_params[$name]) ? $this->validator_params[$name] : $default;
	}
}
