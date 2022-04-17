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
class JSONTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = JSON::class;

	public function provide_test_valid_values()
	{
		return [
			[ 'null' ],
			[ '123' ],
			[ '"123"' ],
			[ '[]' ],
			[ '{"name":"olivier"}' ],
		];
	}

	public function provide_test_invalid_values(): array
    {
		return [
			[ null ],
			[ 123 ],
			[ [] ],
			[ (object) [ 'name' => "olivier" ] ],
		];
	}
}
