<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
abstract class ValidatorTestCase extends TestCase
{
    public const VALIDATOR_CLASS = "";

    protected Validator $validator;
    protected Context $context;

    protected function setUp(): void
    {
        $class = static::VALIDATOR_CLASS;
        $this->validator = new $class();
        $this->context = new Context();
    }

    #[DataProvider('provide_test_valid_values')]
    public function test_valid_values(mixed $value, mixed $params = null, ?string $value_type = null): void
    {
        $this->context->validator_params = $this->validator->normalize_params($params ?: []);
        $this->assertTrue($this->validator->validate($value, $this->context));

        if ($value_type) {
            $this->assertEquals(
                $value_type,
                $this->context->message_args[ComparisonValidatorAbstract::MESSAGE_ARG_VALUE_TYPE]
            );
        }
    }

    abstract public static function provide_test_valid_values(): array;

    #[DataProvider('provide_test_invalid_values')]
    public function test_invalid_values(mixed $value, mixed $params = null, ?string $value_type = null): void
    {
        $this->context->validator_params = $this->validator->normalize_params($params ?: []);
        $this->assertFalse($this->validator->validate($value, $this->context));

        if ($value_type) {
            $this->assertEquals(
                $value_type,
                $this->context->message_args[ComparisonValidatorAbstract::MESSAGE_ARG_VALUE_TYPE]
            );
        }
    }

    abstract public static function provide_test_invalid_values(): array;
}
