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

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is false.
 */
class IsFalse extends AbstractValidator
{
	const ALIAS = 'is-false';
	const DEFAULT_MESSAGE = "should be false";

	const OPTION_FLEXIBLE = 'flexible';

	/**
	 * @inheritdoc
	 */
	public function validate($value, callable $error, Context $context)
	{
		if (filter_var($value, FILTER_VALIDATE_BOOLEAN))
		{
			$error();
		}
	}
}
