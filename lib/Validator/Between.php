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
 * Validates that a value is between two references.
 */
class Between extends AbstractRangeValidator
{
	const ALIAS = 'between';
	const DEFAULT_MESSAGE = "should be between `{min}` and `{max}`";

	/**
	 * @inheritdoc
	 */
	protected function compare($value, $min, $max)
	{
		return $min <= $value && $value <= $max;
	}
}
