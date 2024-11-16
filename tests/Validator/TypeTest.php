<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\ParameterIsMissing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;

#[Small]
class TypeTest extends ValidatorTestCase
{
    public const VALIDATOR_CLASS = Type::class;

    #[DataProvider('provide_test_valid_values')]
    public function test_valid_values(mixed $value, mixed $params = null, ?string $value_type = null): void
    {
        parent::test_valid_values($value, [ Type::PARAM_TYPE => $params ], $value_type);
        parent::test_valid_values($value, [ $params ], $value_type);
    }

    public static function provide_test_valid_values(): array
    {
        $object = new \stdClass();
        $file = fopen(__FILE__, 'r');

        return [
            [ null, 'null' ],
            [ 1, 'integer' ],
            [ '', 'string' ],
            [ true, 'Boolean' ],
            [ false, 'Boolean' ],
            [ true, 'boolean' ],
            [ false, 'boolean' ],
            [ true, 'bool' ],
            [ false, 'bool' ],
            [ 0, 'numeric' ],
            [ '0', 'numeric' ],
            [ 1.5, 'numeric' ],
            [ '1.5', 'numeric' ],
            [ 0, 'integer' ],
            [ 1.5, 'float' ],
            [ '12345', 'string' ],
            [ [], 'array' ],
            [ $object, 'object' ],
            [ $object, 'stdClass' ],
            [ $file, 'resource' ],
            [ '12345', 'digit' ],
            [ '12a34', 'alnum' ],
            [ 'abcde', 'alpha' ],
            [ "\n\r\t", 'cntrl' ],
            [ 'arf12', 'graph' ],
            [ 'abcde', 'lower' ],
            [ 'ABCDE', 'upper' ],
            [ 'arf12', 'print' ],
            [ '*&$()', 'punct' ],
            [ "\n\r\t", 'space' ],
            [ 'AB10BC99', 'xdigit' ],
        ];
    }

    #[DataProvider('provide_test_invalid_values')]
    public function test_invalid_values(mixed $value, mixed $params = null, ?string $value_type = null): void
    {
        parent::test_invalid_values($value, [ Type::PARAM_TYPE => $params ], $value_type);
        parent::test_invalid_values($value, [ $params ], $value_type);
    }

    public static function provide_test_invalid_values(): array
    {
        $object = new \stdClass();
        $file = fopen(__FILE__, 'r');

        return [
            [ 'foobar', 'numeric' ],
            [ 'foobar', 'boolean' ],
            [ '0', 'integer' ],
            [ '1.5', 'float' ],
            [ 12345, 'string' ],
            [ $object, 'boolean' ],
            [ $object, 'numeric' ],
            [ $object, 'integer' ],
            [ $object, 'float' ],
            [ $object, 'string' ],
            [ $object, 'resource' ],
            [ $file, 'boolean' ],
            [ $file, 'numeric' ],
            [ $file, 'integer' ],
            [ $file, 'float' ],
            [ $file, 'string' ],
            [ $file, 'object' ],
            [ '12a34', 'digit' ],
            [ '1a#23', 'alnum' ],
            [ 'abcd1', 'alpha' ],
            [ "\nabc", 'cntrl' ],
            [ "abc\n", 'graph' ],
            [ 'abCDE', 'lower' ],
            [ 'ABcde', 'upper' ],
            [ "\nabc", 'print' ],
            [ 'abc&$!', 'punct' ],
            [ "\nabc", 'space' ],
            [ 'AR1012', 'xdigit' ],
        ];
    }

    public function test_missing_param(): void
    {
        $validator = new Type();

        try {
            $validator->validate(uniqid(), new Context());
        } catch (ParameterIsMissing $e) {
            $this->assertStringEndsWith('::PARAM_TYPE', $e->parameter);

            return;
        }

        $this->fail("Expected ParameterIsMissing");
    }
}
