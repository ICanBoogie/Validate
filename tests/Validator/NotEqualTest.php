<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class NotEqualTest extends EqualTest
{
    public const VALIDATOR_CLASS = NotEqual::class;

    public static function provide_test_valid_values(): array
    {
        return parent::provide_test_invalid_values();
    }

    public static function provide_test_invalid_values(): array
    {
        return parent::provide_test_valid_values();
    }
}
