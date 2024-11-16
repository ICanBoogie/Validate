<?php

namespace ICanBoogie\Validate\ValueReader;

use ICanBoogie\Validate\Reader;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
abstract class ReaderTestCase extends TestCase
{
    public const READER_CLASS = null;

    #[DataProvider('provide_test_read')]
    public function test_read(mixed $data, string $field, mixed $expected): void
    {
        /* @var Reader $reader */
        $class = static::READER_CLASS;
        $reader = new $class($data);
        $this->assertSame($expected, $reader->read($field));
    }

    abstract public static function provide_test_read(): array;
}
