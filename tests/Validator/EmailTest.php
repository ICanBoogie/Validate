<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class EmailTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = Email::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ 'person@domain.com' ],
            [ 'person@domain.co.uk' ],
            [ 'person_name@domain.fr' ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 'person' ],
            [ 'person@' ],
            [ 'person@domain' ],
            [ 'person@domain.com bar' ],
        ];
    }
}
