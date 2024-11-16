<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is a valid email address.
 */
class Email extends ValidatorAbstract
{
    public const ALIAS = 'email';
    public const DEFAULT_MESSAGE = "`{value}` is not a valid email address";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        return !!filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
