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

class NotNullTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = NotNull::class;

	public function provide_test_valid_values()
	{
		return [
			[ 0 ],
			[ false ],
			[ true ],
			[ '' ],
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ null ],
		];
	}
}
