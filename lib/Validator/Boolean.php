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
class Boolean extends AbstractValidator
{
	const ALIAS = 'boolean';
	const DEFAULT_MESSAGE = "should be a boolean";

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		if (!is_scalar($value))
		{
			return false;
		}

		return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
	}
}
