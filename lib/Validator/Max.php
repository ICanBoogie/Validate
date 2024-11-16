<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value has a maximum value.
 */
class Max extends ComparisonValidatorAbstract
{
    public const ALIAS = 'max';
    public const DEFAULT_MESSAGE = "should be at most {reference}";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $reference): bool
    {
        return $value <= $reference;
    }
}
