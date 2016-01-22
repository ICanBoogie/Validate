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
 * Validates that a value is a JSON string.
 */
class JSON extends AbstractValidator
{
	const ALIAS = 'json';
	const DEFAULT_MESSAGE = 'should be a valid JSON string';

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		if (!is_string($value))
		{
			return false;
		}

		json_decode($value);

		return JSON_ERROR_NONE === json_last_error();
	}
}
