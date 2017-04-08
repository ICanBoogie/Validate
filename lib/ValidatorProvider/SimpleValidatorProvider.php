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

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator;

/**
 * Provide simple validators, without dependencies.
 */
class SimpleValidatorProvider
{
	/**
	 * @var array
	 */
	private $aliases = [];

	/**
	 * @var Validator[]
	 */
	private $instances = [];

	/**
	 * @param array $aliases
	 */
	public function __construct(array $aliases)
	{
		$this->aliases = $aliases;
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
		$class = $this->map($class_or_alias);
		$validator = &$this->instances[$class];

		return $validator ?: $validator = $this->instantiate($class);
	}

	/**
	 * Tries to map an validator alias into a validator class.
	 *
	 * @param string $class_or_alias The class or alias of a validator.
	 *
	 * @return string
	 */
	protected function map($class_or_alias)
	{
		return isset($this->aliases[$class_or_alias]) ? $this->aliases[$class_or_alias] : $class_or_alias;
	}

	/**
	 * Instantiates a validator.
	 *
	 * @param string $class
	 *
	 * @return Validator
	 */
	protected function instantiate($class)
	{
		if (!class_exists($class))
		{
			throw new UndefinedValidator($class);
		}

		return new $class;
	}
}
