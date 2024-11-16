<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class JSONTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = JSON::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ 'null' ],
            [ '123' ],
            [ '"123"' ],
            [ '[]' ],
            [ '{"name":"olivier"}' ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ null ],
            [ 123 ],
            [ [] ],
            [ (object)[ 'name' => "olivier" ] ],
        ];
    }
}
