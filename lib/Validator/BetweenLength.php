<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value is between two references.
 */
class BetweenLength extends RangeValidatorAbstract
{
    public const ALIAS = 'between-length';
    public const DEFAULT_MESSAGE = "should be between {min} and {max} characters long";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $min, mixed $max): bool
    {
        return $min <= strlen($value) && strlen($value) <= $max;
    }
}
