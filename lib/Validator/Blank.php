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
class Blank extends AbstractValidator
{
	const ALIAS = 'blank';
	const DEFAULT_MESSAGE = "should be blank";

	/**
	 * @inheritdoc
	 */
	public function validate($value, callable $error, Context $context)
	{
		if ((is_array($value) && count($value)) || $value === false || trim($value) !== '')
		{
			$error();
		}
	}
}
