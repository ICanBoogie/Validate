<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is `null`.
 */
class IsNull extends ValidatorAbstract
{
    public const ALIAS = 'is-null';
    public const DEFAULT_MESSAGE = "should be null";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        return $value === null;
    }
}
