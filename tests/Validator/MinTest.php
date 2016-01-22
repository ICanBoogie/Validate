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

use ICanBoogie\Validate\Validator;

/**
 * @small
 */
class MinTest extends ComparisonValidatorTestCase
{
	const VALIDATOR_CLASS = Min::class;

	public function provide_test_valid_values()
	{
		return [
			[ 12, 10 ],
			[ "abd", "abc" ],
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ 8, 10 ],
			[ "abc", "abd" ],
		];
	}
}
