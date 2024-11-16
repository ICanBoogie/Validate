<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value is between two references.
 */
class Between extends RangeValidatorAbstract
{
    public const ALIAS = 'between';
    public const DEFAULT_MESSAGE = "should be between `{min}` and `{max}`";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $min, mixed $max): bool
    {
        return $min <= $value && $value <= $max;
    }
}
