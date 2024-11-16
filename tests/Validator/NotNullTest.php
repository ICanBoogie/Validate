<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class NotNullTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = NotNull::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ 0 ],
            [ false ],
            [ true ],
            [ '' ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ null ],
        ];
    }
}
