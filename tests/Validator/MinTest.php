<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class MinTest extends ComparisonValidatorTestCase
{
    public const VALIDATOR_CLASS = Min::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ 12, 10 ],
            [ "abd", "abc" ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 8, 10 ],
            [ "abc", "abd" ],
        ];
    }
}
