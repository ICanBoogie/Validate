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
 * Validates that a value has a minimum length.
 */
class MinLength extends AbstractComparisonValidator
{
	const ALIAS = 'min-length';
	const DEFAULT_MESSAGE = "should be at least {reference} characters long";

	/**
	 * @inheritdoc
	 */
	protected function compare($value, $reference)
	{
		return strlen($value) >= $reference;
	}
}
