<?php

namespace ICanBoogie\Validate\Validator;

use Countable;
use ICanBoogie\Validate\Context;

/**
 * Validates that a value is blank.
 */
class Blank extends ValidatorAbstract
{
    public const ALIAS = 'blank';
    public const DEFAULT_MESSAGE = "should be blank";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        if (is_array($value) || $value instanceof Countable) {
            return !count($value);
        }

        if ($value === false) {
            return false;
        }

        return trim($value ?? '') === '';
    }
}
