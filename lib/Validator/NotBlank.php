<?php

namespace ICanBoogie\Validate\Validator;

use Countable;
use ICanBoogie\Validate\Context;

/**
 * Validates that a value is blank.
 */
class NotBlank extends ValidatorAbstract
{
    public const ALIAS = 'not-blank';
    public const DEFAULT_MESSAGE = "should not be blank";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        if (is_array($value) || $value instanceof Countable) {
            return !!count($value);
        }

        return trim($value ?? '') !== '';
    }
}
