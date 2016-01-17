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

class MinLengthTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = MinLength::class;

	public function provide_test_valid_values()
	{
		return [
			[ "abcd", [ MinLength::PARAM_REFERENCE => 2 ] ],
			[ "abcd", [ MinLength::PARAM_REFERENCE => 4 ] ]
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ "abcd", [ MinLength::PARAM_REFERENCE => 10 ] ],
			[ "abcd", [ MinLength::PARAM_REFERENCE => 5 ] ]
		];
	}
}
