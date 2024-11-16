<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\Small;

#[Small]
class IdenticalTest extends ComparisonValidatorTestCase
{
    public const VALIDATOR_CLASS = Identical::class;

    public static function provide_test_valid_values(): array
    {
        $date = new \DateTime('2000-01-01');
        $object = (object)[ 'property' . uniqid() => uniqid() ];
        $immutableDate = new \DateTimeImmutable('2000-01-01');

        return [
            [ 3, 3 ],
            [ 'a', 'a' ],
            [ $date, $date ],
            [ $object, $object ],
//            [ null, 1 ],
            [ $immutableDate, $immutableDate ],
        ];
    }

    public static function provide_test_invalid_values(): array
    {
        return [
            [ 1, 2, 'integer' ],
            [ 2, '2', 'string' ],
            [ '22', '333', 'string' ],
            [ new \DateTime('2001-01-01'), new \DateTime('2001-01-01'), 'object' ],
            [ new \DateTime('2001-01-01'), new \DateTime('1999-01-01'), 'object' ],
            [ (object)[ 'property' => uniqid() ], (object)[ 'property' => uniqid() ], 'object' ],
        ];
    }
}
