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
 * Validates that a value is blank.
 */
class NotBlank extends ValidatorAbstract
{
	const ALIAS = 'not-blank';
	const DEFAULT_MESSAGE = "should not be blank";

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		if (is_array($value) || $value instanceof \Countable)
		{
			return !!count($value);
		}

		return trim($value) !== '';
	}
}
