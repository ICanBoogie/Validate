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

class MaxTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = Max::class;

	public function provide_test_valid_values()
	{
		return [
			[ 8, [ Max::PARAM_REFERENCE => 10 ] ],
			[ 8, [ 10 ] ],
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ 12, [ Max::PARAM_REFERENCE => 10 ] ],
			[ 12, [ 10 ] ],
		];
	}
}
