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
 * Validates that a value is identical to a reference.
 */
class Identical extends AbstractComparisonValidator
{
	const ALIAS = 'identical';
	const DEFAULT_MESSAGE = "should be identical to ({value_type}) `{reference}`";

	/**
	 * @inheritdoc
	 */
	protected function compare($value, $reference)
	{
		return $value === $reference;
	}
}
