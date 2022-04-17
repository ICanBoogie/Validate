<?php

namespace ICanBoogie\Validate\Validator;

class RequiredTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = Required::class;

	public function test_normalize_params()
	{
		$validator = new Required();

		$this->assertSame([

			Required::OPTION_STOP_ON_ERROR => true

		], $validator->normalize_params([]));
	}

	/**
	 * @return array
	 */
	public function provide_test_valid_values()
	{
		return [

			[ true ],
			[ false ],
			[ '0' ],
			[ [ 0 ] ],

		];
	}

	/**
	 * @return array
	 */
	public function provide_test_invalid_values(): array
    {
		return [

			[ null ],
			[ '' ],
			[ ' ' ],
			[ [] ],

		];
	}
}
