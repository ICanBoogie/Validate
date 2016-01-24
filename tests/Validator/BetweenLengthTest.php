<?php

namespace ICanBoogie\Validate\Validator;

class BetweenLengthTest extends RangeValidatorTestCase
{
	const VALIDATOR_CLASS = BetweenLength::class;

	/**
	 * @inheritdoc
	 */
	public function provide_test_valid_values()
	{
		return [

			[ 2, [ 1, 3 ] ],
			[ "2", [ 1, 3 ] ],
			[ "abc", [ 2, 3 ] ],

		];
	}

	/**
	 * @inheritdoc
	 */
	public function provide_test_invalid_values()
	{
		return [

			[ 2 , [ 3, 10 ] ],
			[ "3", [ 3, 10 ] ],
			[ "abc", [ 5, 6 ] ],

		];
	}
}
