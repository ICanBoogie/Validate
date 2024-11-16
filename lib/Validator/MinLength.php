<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value has a minimum length.
 */
class MinLength extends ComparisonValidatorAbstract
{
    public const ALIAS = 'min-length';
    public const DEFAULT_MESSAGE = "should be at least {reference} characters long";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $reference): bool
    {
        return strlen($value) >= $reference;
    }
}
