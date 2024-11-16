<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value is identical to a reference.
 */
class Identical extends ComparisonValidatorAbstract
{
    public const ALIAS = 'identical';
    public const DEFAULT_MESSAGE = "should be identical to ({value_type}) `{reference}`";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $reference): bool
    {
        return $value === $reference;
    }
}
