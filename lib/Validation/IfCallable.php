<?php

namespace ICanBoogie\Validate\Validation;

use ICanBoogie\Validate\Context;

/**
 * Callable interface for the {@see ValidatorOptions::OPTION_IF} option.
 */
interface IfCallable
{
    /**
     * Whether the validator should be used.
     */
    public function __invoke(Context $context): bool;
}
