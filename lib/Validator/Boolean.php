<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is false.
 */
class Boolean extends ValidatorAbstract
{
    public const ALIAS = 'boolean';
    public const DEFAULT_MESSAGE = "should be a boolean";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        if (!is_scalar($value)) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
    }
}
