<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is false.
 */
class IsFalse extends ValidatorAbstract
{
    public const ALIAS = 'is-false';
    public const DEFAULT_MESSAGE = "should be false";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        return !filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
