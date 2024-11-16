<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value has a maximum length.
 */
class MaxLength extends ComparisonValidatorAbstract
{
    public const ALIAS = 'max-length';
    public const DEFAULT_MESSAGE = "should be at most {reference} characters long";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $reference): bool
    {
        return strlen($value) <= $reference;
    }
}
