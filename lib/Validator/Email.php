<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value is a valid email.
 */
class Email extends AbstractValidator
{
	const ALIAS = 'email';
	const DEFAULT_MESSAGE = "`{value}` is not a valid email address";

	/**
	 * @inheritdoc
	 */
	public function validate($value, array $options, callable $error)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL))
		{
			$error();
		}
	}
}
