<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use PHPUnit\Framework\Attributes\Small;

#[Small]
class TimeZoneTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = TimeZone::class;

    public static function provide_test_valid_values(): array
    {
        return [
            [ 'Europe/Paris' ],
            [ 'Asia/Tokyo' ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 'Paris' ],
            [ 'Tokyo' ],
            [ '+02:00' ],
        ];
    }

    public function test_suggestion(): void
    {
        $validator = new TimeZone();
        $context = new Context();
        $this->assertFalse($validator->validate('Europe/Pas', $context));
        $this->assertArrayHasKey('suggestion', $context->message_args);
        $this->assertEquals('Europe/Paris', $context->message_args['suggestion']);
    }
}
