<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value is not identical to a reference.
 */
class NotIdentical extends ComparisonValidatorAbstract
{
    public const ALIAS = 'not-identical';
    public const DEFAULT_MESSAGE = "should not be identical to ({value_type}) `{reference}`";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $reference): bool
    {
        return $value !== $reference;
    }
}
