<?php

namespace ICanBoogie\Validate\Validator;

class BetweenLengthTest extends RangeValidatorTestCase
{
    public const VALIDATOR_CLASS = BetweenLength::class;

    public static function provide_test_valid_values(): array
    {
        return [

            [ 2, [ 1, 3 ] ],
            [ "2", [ 1, 3 ] ],
            [ "abc", [ 2, 3 ] ],

        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [

            [ 2, [ 3, 10 ] ],
            [ "3", [ 3, 10 ] ],
            [ "abc", [ 5, 6 ] ],

        ];
    }
}
