<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is a valid URL.
 */
class URL extends ValidatorAbstract
{
    public const ALIAS = 'url';
    public const DEFAULT_MESSAGE = "`{value}` is not a valid URL";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        return !!filter_var($value, FILTER_VALIDATE_URL);
    }
}
