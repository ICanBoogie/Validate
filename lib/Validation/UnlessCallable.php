<?php

namespace ICanBoogie\Validate\Validation;

use ICanBoogie\Validate\Context;

/**
 * Callable interface for the {@see ValidatorOptions::OPTION_UNLESS} option.
 */
interface UnlessCallable
{
    /**
     * Whether the validator should be skipped.
     */
    public function __invoke(Context $context): bool;
}
