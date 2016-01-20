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
	 * @param string $class_or_alias
	 *
	 * @return Validator
	 */
	public function __invoke($class_or_alias)
	{
		$class_or_alias = $this->map($class_or_alias);
		$validator = &$this->instances[$class_or_alias];

		if (!$validator)
		{
			$validator = $this->instantiate($class_or_alias);
		}

		return $validator;
	}

	/**
	 * Tries to map an validator alias into a validator class.
	 *
	 * @param string $class_or_alias The class of alias of the validator.
	 *
	 * @return string
	 */
	protected function map($class_or_alias)
	{
		if (isset($this->mapping[$class_or_alias]))
		{
			return $this->mapping[$class_or_alias];
		}

		return $class_or_alias;
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
