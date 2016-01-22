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
class IsTrueTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = IsTrue::class;

	public function provide_test_valid_values()
	{
		return [
			[ true ],
			[ 'true' ],
			[ 'yes' ],
			[ 'on' ],
			[ 1 ],
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ false ],
			[ 'false' ],
			[ 'no' ],
			[ 'off' ],
			[ 0 ],
		];
	}
}
