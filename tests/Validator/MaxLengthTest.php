<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class MaxLengthTest extends ComparisonValidatorTestCase
{
    public const VALIDATOR_CLASS = MaxLength::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ "abcd", 10 ],
            [ "abcd", 4 ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ "abcd", 2 ],
            [ "abcd", 3 ],
        ];
    }
}
