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
class EqualTest extends ComparisonValidatorTestCase
{
	const VALIDATOR_CLASS = Equal::class;

	/**
	 * @inheritdoc
	 */
	public function provide_test_valid_values()
	{
		return [
			[ 3, 3 ],
			[ 3, '3' ],
			[ 'a', 'a' ],
			[ (object) [ 'p' => 5 ], (object) [ 'p' => 5 ] ],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function provide_test_invalid_values()
	{
		return [
			[ 1, 2 ],
			[ '22', '333' ],
			[ (object) [ 'p' => 4 ], (object) [ 'p' => 5 ] ],
			[ null, 1 ],
		];
	}
}
