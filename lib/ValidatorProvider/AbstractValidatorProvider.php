<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\Validator;
use ICanBoogie\Validate\ValidatorProvider;

/**
 * Abstract class for validator provider.
 */
abstract class AbstractValidatorProvider implements ValidatorProvider
{
	/**
	 * @var Validator[]
	 */
	private $instances = [];

	/**
	 * @var array
	 */
	private $mapping = [];

	/**
	 * @param Validator[] $instances
	 * @param array $aliases
	 */
	public function __construct(array $instances = [], array $aliases = [])
	{
		$this->instances = $instances;
		$this->mapping = $aliases;
	}

	/**
	 * Returns a validator.
	 *
	 * @param string $validator_name
	 *
	 * @return Validator
	 */
	public function __invoke($validator_name)
	{
		$validator_name = $this->map($validator_name);
		$validator = &$this->instances[$validator_name];

		if (!$validator)
		{
			$validator = $this->instantiate($validator_name);
		}

		return $validator;
	}

	/**
	 * Tries to map a validator name into a validator class.
	 *
	 * @param string $validator_name
	 *
	 * @return string
	 */
	protected function map($validator_name)
	{
		if (isset($this->mapping[$validator_name]))
		{
			return $this->mapping[$validator_name];
		}

		return $validator_name;
	}

	/**
	 * Instantiates a validator.
	 *
	 * @param string $validator_class
	 *
	 * @return Validator
	 */
	protected function instantiate($validator_class)
	{
		return new $validator_class;
	}
}