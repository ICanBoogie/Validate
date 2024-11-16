<?php

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator\SampleValidator;
use PHPUnit\Framework\TestCase;

class ValidatorProviderCollectionTest extends TestCase
{
    public function test_should_throw_exception_if_validator_if_not_defined(): void
    {
        $provider = new ValidatorProviderCollection();
        $this->expectException(UndefinedValidator::class);
        $provider(uniqid());
    }

    public function test_should_add_provider(): void
    {
        $provider1 = function () {
        };
        $provider2 = function () {
        };
        $provider3 = function () {
        };
        $provider = (new ValidatorProviderCollection())
            ->add($provider1)
            ->add($provider2)
            ->add($provider3);

        $this->assertSame([

            $provider3,
            $provider2,
            $provider1,

        ], iterator_to_array($provider));
    }

    public function test_should_return_custom_validator(): void
    {
        $validator = new SampleValidator();

        $failing_provider = function ($class_or_alias) {
            throw new UndefinedValidator($class_or_alias);
        };

        $sample_provider = fn($class_or_alias) => match ($class_or_alias) {
            SampleValidator::ALIAS, SampleValidator::class => $validator,
            default => throw new UndefinedValidator($class_or_alias),
        };

        $provider = new ValidatorProviderCollection([

            $failing_provider,
            $sample_provider,
            new BuiltinValidatorProvider(),

        ]);

        $this->assertSame($validator, $provider(SampleValidator::ALIAS));
        $this->assertSame($validator, $provider(SampleValidator::class));
    }
}
