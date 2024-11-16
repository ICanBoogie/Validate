<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class IsNullTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = IsNull::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ null ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 0 ],
            [ false ],
            [ true ],
            [ '' ],
            [ 'foo bar' ],
            [ new \DateTime() ],
            [ new \stdClass() ],
            [ [] ],
        ];
    }
}
