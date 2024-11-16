<?php

namespace ICanBoogie\Validate;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
class MessageTest extends TestCase
{
    #[DataProvider('provide_test_format')]
    public function test_format(string $message, mixed $value, string $expected): void
    {
        $this->assertSame($expected, (string)new Message($message, [ 'value' => $value ]));
    }

    public static function provide_test_format(): array
    {
        return [

            [ '`{value}` is invalid', 1, '`1` is invalid' ],
            [ '`{value}` is invalid', null, '`null` is invalid' ],
            [ '`{value}` is invalid', true, '`true` is invalid' ],
            [ '`{value}` is invalid', false, '`false` is invalid' ],
            [ '`{value}` is invalid', new \stdClass(), '`instance of stdClass` is invalid' ],
            [ '`{value}` is invalid', [ 'one' => 1, 'two' => 2 ], '`array{one, two}` is invalid' ],
            [ '`{value}` is invalid', fopen(__FILE__, 'r'), '`type{resource}` is invalid' ],

        ];
    }
}
