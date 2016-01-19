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
 * Exception throw when an asserting a validation failed.
 *
 * @property-read ValidationErrors $errors
 */
class ValidationFailed extends \LogicException
{
	const DEFAULT_MESSAGE = "Validation failed.";

	/**
	 * @var ValidationErrors
	 */
	public $errors;

	/**
	 * @param ValidationErrors $errors
	 * @param \Exception|null $previous
	 */
	public function __construct(ValidationErrors $errors, \Exception $previous = null)
	{
		$this->errors = $errors;

		parent::__construct($this->format_message($errors), 500, $previous);
	}

	/**
	 * Formats the exception message.
	 *
	 * @param ValidationErrors $errors
	 *
	 * @return string
	 */
	protected function format_message(ValidationErrors $errors)
	{
		$message = self::DEFAULT_MESSAGE . "\n";

		foreach ($errors as $attribute => $attribute_errors)
		{
			foreach ($attribute_errors as $error)
			{
				$message .= "\n- $attribute: $error";
			}
		}

		return $message;
	}
}
