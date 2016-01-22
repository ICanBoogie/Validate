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
 * Validates that a value is not between two references.
 */
class NotBetween extends Between
{
	const ALIAS = 'not-between';
	const DEFAULT_MESSAGE = "should not be between `{min}` and `{max}`";

	/**
	 * @inheritdoc
	 */
	protected function compare($value, $min, $max)
	{
		return !parent::compare($value, $min, $max);
	}
}
