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
class BooleanTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = Boolean::class;

	public function provide_test_valid_values()
	{
		return [
			[ false ],
			[ 'false' ],
			[ 'off' ],
			[ 'no' ],
			[ 0 ],
			[ true ],
			[ 'true' ],
			[ 'on' ],
			[ 'yes' ],
			[ 1 ],
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ null ],
			[ 'abc' ],
			[ [ ] ],
			[ (object) [ 'p' => 1 ] ]
		];
	}
}
