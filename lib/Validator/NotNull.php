<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is not `null`.
 */
class NotNull extends ValidatorAbstract
{
    public const ALIAS = 'not-null';
    public const DEFAULT_MESSAGE = "should not be null";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        return $value !== null;
    }
}
