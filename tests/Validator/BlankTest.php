<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class BlankTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = Blank::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ null ],
            [ '' ],
            [ [] ]
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 'foobar' ],
            [ 0 ],
            [ false ],
            [ 1234 ]
        ];
    }
}
