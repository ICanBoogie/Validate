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

use ICanBoogie\Validate\Validator\AbstractValidator;

/**
 * Validates that a value is true.
 */
class IsTrue extends AbstractValidator
{
	const ALIAS = 'is-true';
	const DEFAULT_MESSAGE = "should be true";

	const OPTION_FLEXIBLE = 'flexible';

	/**
	 * @inheritdoc
	 */
	public function validate($value, array $options, callable $error)
	{
		if (!filter_var($value, FILTER_VALIDATE_BOOLEAN))
		{
			$error();
		}
	}
}
