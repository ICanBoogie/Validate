<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class NotBlankTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = NotBlank::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ 'foobar' ],
            [ 0 ],
            [ 0.0 ],
            [ '0' ],
            [ 1234 ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ null ],
            [ '' ],
            [ false ],
            [ [] ]
        ];
    }
}
