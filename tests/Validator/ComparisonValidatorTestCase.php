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

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\Validator;

/**
 * @small
 */
abstract class ComparisonValidatorTestCase extends ValidatorTestCase
{
	/**
	 * @dataProvider provide_test_valid_values
	 *
	 * @param mixed $value
	 * @param mixed $reference
	 */
	public function test_valid_values($value, $reference = null)
	{
		parent::test_valid_values($value, [ $reference ]);
	}

	/**
	 * @dataProvider provide_test_invalid_values
	 *
	 * @param mixed $value
	 * @param mixed $reference
	 */
	public function test_invalid_values($value, $reference = null)
	{
		parent::test_invalid_values($value, [ $reference ]);
	}
}
