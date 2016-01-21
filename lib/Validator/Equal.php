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
 * Validates that a value equals a reference.
 */
class Equal extends AbstractComparisonValidator
{
	const ALIAS = 'equal';
	const DEFAULT_MESSAGE = "should equal {reference}";

	/**
	 * @inheritdoc
	 */
	protected function compare($value, $reference)
	{
		return $value == $reference;
	}
}
