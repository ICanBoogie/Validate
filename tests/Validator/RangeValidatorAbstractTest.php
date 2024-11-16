<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\ParameterIsMissing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
class RangeValidatorAbstractTest extends TestCase
{
    private RangeValidatorAbstract $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new class () extends RangeValidatorAbstract {
            protected function compare(mixed $value, mixed $min, mixed $max): bool
            {
                return false;
            }
        };
    }

    public function test_normalize_params(): void
    {
        $min = mt_rand(10, 20);
        $max = mt_rand(30, 40);

        $this->assertSame([

            RangeValidatorAbstract::PARAM_MIN => $min,
            RangeValidatorAbstract::PARAM_MAX => $max,

        ], $this->sut->normalize_params([ $min, $max ]));
    }

    #[DataProvider('provide_param')]
    public function test_should_throw_exception_on_missing_param(array $params, string $missing): void
    {
        try {
            $context = new Context();
            $context->validator_params = $params;
            $this->sut->validate(uniqid(), $context);
        } catch (ParameterIsMissing $e) {
            $this->assertStringEndsWith("::PARAM_$missing", $e->parameter);

            return;
        }

        $this->fail("Expected ParameterIsMissing");
    }

    public static function provide_param(): array
    {
        return [

            [ [ RangeValidatorAbstract::PARAM_MAX => 10 ], 'MIN' ],
            [ [ RangeValidatorAbstract::PARAM_MIN => 10 ], 'MAX' ],

        ];
    }

    public function test_message_args(): void
    {
        $context = new Context();
        $min = mt_rand(10, 20);
        $max = mt_rand(30, 40);
        $context->validator_params = [

            RangeValidatorAbstract::PARAM_MIN => $min,
            RangeValidatorAbstract::PARAM_MAX => $max,

        ];

        $this->sut->validate(mt_rand(50, 60), $context);

        $this->assertArrayHasKey(RangeValidatorAbstract::MESSAGE_ARG_MIN, $context->message_args);
        $this->assertArrayHasKey(RangeValidatorAbstract::MESSAGE_ARG_MAX, $context->message_args);
        $this->assertArrayHasKey(RangeValidatorAbstract::MESSAGE_ARG_VALUE_TYPE, $context->message_args);
        $this->assertSame($min, $context->message_args[RangeValidatorAbstract::MESSAGE_ARG_MIN]);
        $this->assertSame($max, $context->message_args[RangeValidatorAbstract::MESSAGE_ARG_MAX]);
        $this->assertSame('integer', $context->message_args[RangeValidatorAbstract::MESSAGE_ARG_VALUE_TYPE]);
    }
}
