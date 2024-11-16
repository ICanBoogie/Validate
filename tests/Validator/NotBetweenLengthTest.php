<?php

namespace ICanBoogie\Validate\Validator;

class NotBetweenLengthTest extends BetweenLengthTest
{
    public const VALIDATOR_CLASS = NotBetweenLength::class;

    public static function provide_test_valid_values(): array
    {
        return parent::provide_test_invalid_values();
    }

    public static function provide_test_invalid_values(): array
    {
        return parent::provide_test_valid_values();
    }
}
