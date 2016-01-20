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
class IsNullTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = IsNull::class;

	public function provide_test_valid_values()
	{
		return [
			[ null ],
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ 0 ],
			[ false ],
			[ true ],
			[ '' ],
			[ 'foo bar' ],
			[ new \DateTime() ],
			[ new \stdClass() ],
			[ [ ] ],
		];
	}
}
