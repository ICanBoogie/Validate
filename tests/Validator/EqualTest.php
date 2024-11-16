<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class EqualTest extends ComparisonValidatorTestCase
{
    public const VALIDATOR_CLASS = Equal::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ 3, 3 ],
            [ 3, '3' ],
            [ 'a', 'a' ],
            [ (object)[ 'p' => 5 ], (object)[ 'p' => 5 ] ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 1, 2 ],
            [ '22', '333' ],
            [ (object)[ 'p' => 4 ], (object)[ 'p' => 5 ] ],
            [ null, 1 ],
        ];
    }
}
