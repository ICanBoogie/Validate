<?php

namespace ICanBoogie\Validate\ValueReader;

use ICanBoogie\Validate\Reader\ArrayAdapter;
use PHPUnit\Framework\Attributes\Small;

#[Small]
class ArrayAdapterTest extends ReaderTestCase
{
    public const READER_CLASS = ArrayAdapter::class;

    public static function provide_test_read(): array
    {
        $p1 = uniqid();
        $v1 = uniqid();

        return [

            [ [ $p1 => $v1 ], $p1, $v1 ],
            [ [ $p1 => '0' ], $p1, '0' ],
            [ [ $p1 => false ], $p1, false ],
            [ [ $p1 => '' ], $p1, '' ],
            [ [ $p1 => ' ' ], $p1, ' ' ],
            [ [ $p1 => [] ], $p1, [] ],
            [ [], $p1, null ],

        ];
    }
}
