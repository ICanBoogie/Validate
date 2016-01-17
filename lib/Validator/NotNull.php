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
 * Validates that a value is not null.
 */
class NotNull extends AbstractValidator
{
	const ALIAS = 'not-null';
	const DEFAULT_MESSAGE = "should not be null";

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		return $value !== null;
	}
}
