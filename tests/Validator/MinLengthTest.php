<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class MinLengthTest extends ComparisonValidatorTestCase
{
    public const VALIDATOR_CLASS = MinLength::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ "abcd", 2 ],
            [ "abcd", 4 ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ "abcd", 10 ],
            [ "abcd", 5 ],
        ];
    }
}
