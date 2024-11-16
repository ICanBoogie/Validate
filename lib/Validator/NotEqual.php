<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value does not equal a reference.
 */
class NotEqual extends ComparisonValidatorAbstract
{
    public const ALIAS = 'not-equal';
    public const DEFAULT_MESSAGE = "should not equal {reference}";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $reference): bool
    {
        return $value != $reference;
    }
}
