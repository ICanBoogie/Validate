<?php

namespace ICanBoogie\Validate\ValueReader;

use ICanBoogie\Validate\Reader\ObjectAdapter;
use PHPUnit\Framework\Attributes\Small;

#[Small]
class ObjectAdapterTest extends ReaderTestCase
{
    public const READER_CLASS = ObjectAdapter::class;

    public static function provide_test_read(): array
    {
        $p1 = 'property' . uniqid();
        $v1 = uniqid();

        return [

            [ (object)[ $p1 => $v1 ], $p1, $v1 ],
            [ (object)[ $p1 => '0' ], $p1, '0' ],
            [ (object)[ $p1 => false ], $p1, false ],
            [ (object)[ $p1 => '' ], $p1, '' ],
            [ (object)[ $p1 => ' ' ], $p1, ' ' ],
            [ (object)[ $p1 => [] ], $p1, [] ],
            [ (object)[], $p1, null ],

        ];
    }
}
