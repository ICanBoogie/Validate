<?php

namespace ICanBoogie\Validate\Validator;

class NotBetweenTest extends BetweenTest
{
    public const VALIDATOR_CLASS = NotBetween::class;

    public static function provide_test_valid_values(): array
    {
        return parent::provide_test_invalid_values();
    }

    public static function provide_test_invalid_values(): array
    {
        return parent::provide_test_valid_values();
    }
}
