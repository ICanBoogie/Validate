<?php

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\TestCase;

#[Medium]
class BuiltinValidatorProviderTest extends TestCase
{
    private BuiltinValidatorProvider $sut;

    protected function setUp(): void
    {
        $this->sut = new BuiltinValidatorProvider();
    }

    public function test_should_throw_exception_if_validator_is_not_defined(): void
    {
        $provider = $this->sut;
        $this->expectException(UndefinedValidator::class);
        $provider(uniqid());
    }

    /**
     * @param class-string $class
     */
    #[DataProvider('provide_test_alias_mapping')]
    public function test_alias_mapping(string $class, string $alias): void
    {
        $provider = $this->sut;
        $validator = $provider($class);
        $this->assertInstanceOf($class, $validator);
        $this->assertSame($validator, $provider($alias));
    }

    public static function provide_test_alias_mapping(): array
    {
        return array_map(function ($class) {
            return [ $class, $class::ALIAS ];
        }, [

            Validator\Between::class,
            Validator\BetweenLength::class,
            Validator\Blank::class,
            Validator\Boolean::class,
            Validator\Email::class,
            Validator\Equal::class,
            Validator\Identical::class,
            Validator\IsFalse::class,
            Validator\IsNull::class,
            Validator\IsTrue::class,
            Validator\JSON::class,
            Validator\Max::class,
            Validator\MaxLength::class,
            Validator\Min::class,
            Validator\MinLength::class,
            Validator\NotBetween::class,
            Validator\NotBetweenLength::class,
            Validator\NotBlank::class,
            Validator\NotEqual::class,
            Validator\NotIdentical::class,
            Validator\NotNull::class,
            Validator\Regex::class,
            Validator\Required::class,
            Validator\TimeZone::class,
            Validator\Type::class,
            Validator\URL::class,

        ]);
    }
}
