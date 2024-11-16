<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class BooleanTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = Boolean::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ false ],
            [ 'false' ],
            [ 'off' ],
            [ 'no' ],
            [ 0 ],
            [ true ],
            [ 'true' ],
            [ 'on' ],
            [ 'yes' ],
            [ 1 ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ null ],
            [ 'abc' ],
            [ [] ],
            [ (object)[ 'p' => 1 ] ]
        ];
    }
}
