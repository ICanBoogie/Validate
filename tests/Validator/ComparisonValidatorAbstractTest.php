<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\ParameterIsMissing;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
class ComparisonValidatorAbstractTest extends TestCase
{
    private ComparisonValidatorAbstract $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new class extends ComparisonValidatorAbstract {
            protected function compare(mixed $value, mixed $reference): bool
            {
                return false;
            }
        };
    }

    public function test_should_throw_exception_on_missing_reference(): void
    {
        try {
            $this->sut->validate(uniqid(), new Context());
        } catch (ParameterIsMissing $e) {
            $this->assertStringEndsWith('::PARAM_REFERENCE', $e->parameter);

            return;
        }

        $this->fail("Expected ParameterIsMissing");
    }

    public function test_should_add_message_arg_reference(): void
    {
        $context = new Context();
        $reference = uniqid();
        $context->validator_params = [ ComparisonValidatorAbstract::PARAM_REFERENCE => $reference ];
        $this->sut->validate(uniqid(), $context);

        $this->assertArrayHasKey(ComparisonValidatorAbstract::MESSAGE_ARG_REFERENCE, $context->message_args);
        $this->assertSame($reference, $context->message_args[ComparisonValidatorAbstract::MESSAGE_ARG_REFERENCE]);
    }

    public function test_should_add_message_arg_value_type(): void
    {
        $context = new Context();
        $reference = new class {
        };
        $context->validator_params = [ ComparisonValidatorAbstract::PARAM_REFERENCE => $reference ];
        $this->sut->validate(uniqid(), $context);

        $this->assertArrayHasKey(ComparisonValidatorAbstract::MESSAGE_ARG_VALUE_TYPE, $context->message_args);
        $this->assertSame(
            gettype($reference),
            $context->message_args[ComparisonValidatorAbstract::MESSAGE_ARG_VALUE_TYPE],
        );
    }
}
