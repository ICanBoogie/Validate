<?php

namespace ICanBoogie\Validate\Validator;

class RequiredTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = Required::class;

    public function test_normalize_params()
    {
        $validator = new Required();

        $this->assertSame([

            Required::OPTION_STOP_ON_ERROR => true

        ], $validator->normalize_params([]));
    }

    public static function provide_test_valid_values(): array
    {
        return [

            [ true ],
            [ false ],
            [ '0' ],
            [ [ 0 ] ],

        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [

            [ null ],
            [ '' ],
            [ ' ' ],
            [ [] ],

        ];
    }
}
