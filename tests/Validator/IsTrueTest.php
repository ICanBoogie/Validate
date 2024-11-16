<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class IsTrueTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = IsTrue::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ true ],
            [ 'true' ],
            [ 'yes' ],
            [ 'on' ],
            [ 1 ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ false ],
            [ 'false' ],
            [ 'no' ],
            [ 'off' ],
            [ 0 ],
        ];
    }
}
