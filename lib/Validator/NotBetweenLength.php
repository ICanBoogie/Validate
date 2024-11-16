<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value is between two references.
 */
class NotBetweenLength extends BetweenLength
{
    public const ALIAS = 'not-between-length';
    public const DEFAULT_MESSAGE = "should not be between {min} and {max} characters long";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $min, mixed $max): bool
    {
        return !parent::compare($value, $min, $max);
    }
}
