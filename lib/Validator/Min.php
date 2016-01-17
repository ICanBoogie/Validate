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
 * Validates that a value has a minimum value.
 */
class Min extends AbstractComparisonValidator
{
	const ALIAS = 'min';
	const DEFAULT_MESSAGE = "should be at least {reference}";

	/**
	 * @inheritdoc
	 */
	protected function compare($value, $reference)
	{
		return $value >= $reference;
	}
}
