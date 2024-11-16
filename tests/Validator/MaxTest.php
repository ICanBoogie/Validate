<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class MaxTest extends ComparisonValidatorTestCase
{
    public const VALIDATOR_CLASS = Max::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ 8, 10 ],
            [ "abc", "abd" ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 12, 10 ],
            [ "abd", "abc" ],
        ];
    }
}
