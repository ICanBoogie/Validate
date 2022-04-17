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

use LogicException;

/**
 * Exception throw if a validator is not defined.
 *
 * @property-read string $class_or_alias
 */
class UndefinedValidator extends LogicException
{
	/**
	 * @var string
	 */
	private $class_or_alias;

	/**
	 * @param string $class_or_alias
	 * @param \Exception|null $previous
	 */
	public function __construct($class_or_alias, \Exception $previous = null)
	{
		parent::__construct($this->format_message($class_or_alias), 0, $previous);
		$this->class_or_alias = $class_or_alias;
	}

	/**
	 * @inheritdoc
	 */
	public function __get($name)
	{
		if ($name === 'class_or_alias')
		{
			return $this->class_or_alias;
		}

		throw new LogicException("Undefined or inaccessible property: $name.");
	}

	/**
	 * @param string $class_or_alias
	 *
	 * @return string
	 */
	protected function format_message($class_or_alias)
	{
		return "Undefined validator: $class_or_alias.";
	}
}
