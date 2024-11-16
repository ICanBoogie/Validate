<?php

namespace ICanBoogie\Validate\Validator;

use DateTime;

class BetweenTest extends RangeValidatorTestCase
{
    public const VALIDATOR_CLASS = Between::class;

    public static function provide_test_valid_values(): array
    {
        return [

            [ 2, [ 1, 3 ] ],
            [ "2", [ 1, 3 ] ],
            [ "abc", [ "aba", "abd" ] ],
            [ [ 2 ], [ [ 1 ], [ 3 ] ] ],
            [ new DateTime(), [ new DateTime('-10 second'), new DateTime('+10 second') ] ]

        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [

            [ null, [ -1, 1 ] ],
            [ [ 2 ], [ 1, 3 ] ],
            [ 3, [ 1, 2 ] ],
            [ "abc", [ "aba", "abb" ] ],
            [ new DateTime('-10 second'), [ new DateTime(), new DateTime('+10 second') ] ]

        ];
    }
}
