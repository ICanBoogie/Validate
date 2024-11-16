<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value is not between two references.
 */
class NotBetween extends Between
{
    public const ALIAS = 'not-between';
    public const DEFAULT_MESSAGE = "should not be between `{min}` and `{max}`";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $min, mixed $max): bool
    {
        return !parent::compare($value, $min, $max);
    }
}
