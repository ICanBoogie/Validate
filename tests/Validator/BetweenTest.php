<?php

namespace ICanBoogie\Validate\Validator;

class BetweenTest extends RangeValidatorTestCase
{
	const VALIDATOR_CLASS = Between::class;

	/**
	 * @inheritdoc
	 */
	public function provide_test_valid_values()
	{
		return [

			[ 2, [ 1, 3 ] ],
			[ "2", [ 1, 3 ] ],
			[ "abc", [ "aba", "abd" ] ],
			[ [ 2 ], [ [ 1 ], [ 3 ] ] ],
			[ new \DateTime, [ new \DateTime('-10 second'), new \DateTime('+10 second') ] ]

		];
	}

	/**
	 * @inheritdoc
	 */
	public function provide_test_invalid_values(): array
    {
		return [

			[ null, [ -1, 1 ] ],
			[ [ 2 ], [ 1, 3 ] ],
			[ 3, [ 1, 2 ] ],
			[ "abc", [ "aba", "abb" ] ],
			[ new \DateTime('-10 second'), [ new \DateTime, new \DateTime('+10 second') ] ]

		];
	}
}
