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
class RegexTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = Regex::class;

	public function provide_test_valid_values()
	{
		return [
			[ '1234', [ '/^\d+$/' ] ],
			[ '1234', [ '/^\d+$/', Regex::MATCH ] ],
			[ 'abcd', [ '/^\d+$/', Regex::NOT_MATCH ] ],
			[ 0, [ '/^\d+$/' ] ],
			[ '0', [ '/^\d+$/' ] ],
			[ 1234, [ '/^\d+$/' ] ],
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ 'abcd', [ '/^\d+$/' ] ],
			[ 'abcd', [ '/^\d+$/', Regex::MATCH ] ],
			[ '1234', [ '/^\d+$/', Regex::NOT_MATCH ] ],
		];
	}
}
