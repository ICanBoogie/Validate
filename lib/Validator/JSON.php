<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is a JSON string.
 */
class JSON extends ValidatorAbstract
{
    public const ALIAS = 'json';
    public const DEFAULT_MESSAGE = 'should be a valid JSON string';

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        if (!is_string($value)) {
            return false;
        }

        json_decode($value);

        return JSON_ERROR_NONE === json_last_error();
    }
}
