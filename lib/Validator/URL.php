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
 * Validates that a value is a valid URL.
 */
class URL extends AbstractValidator
{
	const ALIAS = 'url';
	const DEFAULT_MESSAGE = "`{value}` is not a valid URL";

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		return !!filter_var($value, FILTER_VALIDATE_URL);
	}
}
