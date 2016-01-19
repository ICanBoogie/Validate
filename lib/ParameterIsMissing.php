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
 * Exception thrown when a required validator parameter is missing.
 *
 * @property-read string $parameter
 */
class ParameterIsMissing extends \LogicException
{
	/**
	 * @var string
	 */
	public $parameter;

	/**
	 * @param string $parameter
	 * @param \Exception|null $previous
	 */
	public function __construct($parameter, \Exception $previous = null)
	{
		$this->parameter = $parameter;

		parent::__construct($this->format_message($parameter), 500, $previous);
	}

	/**
	 * Formats exception message.
	 *
	 * @param string $parameter
	 *
	 * @return string
	 */
	protected function format_message($parameter)
	{
		return "Parameter `$parameter` is missing.";
	}
}
