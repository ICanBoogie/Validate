<?php

namespace ICanBoogie\Validate\Validator;

/**
 * Validates that a value equals a reference.
 */
class Equal extends ComparisonValidatorAbstract
{
    public const ALIAS = 'equal';
    public const DEFAULT_MESSAGE = "should equal {reference}";

    /**
     * @inheritdoc
     */
    protected function compare(mixed $value, mixed $reference): bool
    {
        return $value == $reference;
    }
}
