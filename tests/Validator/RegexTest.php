<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class RegexTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = Regex::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ '1234', [ '/^\d+$/' ] ],
            [ '1234', [ '/^\d+$/', Regex::MATCH ] ],
            [ 'abcd', [ '/^\d+$/', Regex::NOT_MATCH ] ],
            [ 0, [ '/^\d+$/' ] ],
            [ '0', [ '/^\d+$/' ] ],
            [ 1234, [ '/^\d+$/' ] ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 'abcd', [ '/^\d+$/' ] ],
            [ 'abcd', [ '/^\d+$/', Regex::MATCH ] ],
            [ '1234', [ '/^\d+$/', Regex::NOT_MATCH ] ],
        ];
    }
}
