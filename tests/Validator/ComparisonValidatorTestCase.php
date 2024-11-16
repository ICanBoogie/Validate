<?php

namespace ICanBoogie\Validate\Validator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;

#[Small]
abstract class ComparisonValidatorTestCase extends ValidatorTestCase
{
    #[DataProvider('provide_test_valid_values')]
    public function test_valid_values(mixed $value, mixed $params = null, ?string $value_type = null): void
    {
        parent::test_valid_values($value, [ $params ], $value_type);
    }

    #[DataProvider('provide_test_invalid_values')]
    public function test_invalid_values(mixed $value, mixed $params = null, ?string $value_type = null): void
    {
        parent::test_invalid_values($value, [ $params ], $value_type);
    }
}
