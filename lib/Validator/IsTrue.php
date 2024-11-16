<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is true.
 */
class IsTrue extends ValidatorAbstract
{
    public const ALIAS = 'is-true';
    public const DEFAULT_MESSAGE = "should be true";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
