<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value has a minimum value.
 */
class Min extends ComparisonValidatorAbstract
{
    public const ALIAS = 'min';
    public const DEFAULT_MESSAGE = "should be at least {reference}";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $reference): bool
    {
        return $value >= $reference;
    }
}
