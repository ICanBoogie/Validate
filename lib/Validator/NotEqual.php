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
 * Validates that a value does not equal a reference.
 */
class NotEqual extends ComparisonValidatorAbstract
{
	const ALIAS = 'not-equal';
	const DEFAULT_MESSAGE = "should not equal {reference}";

	/**
	 * @inheritdoc
	 */
	protected function compare($value, $reference)
	{
		return $value != $reference;
	}
}
