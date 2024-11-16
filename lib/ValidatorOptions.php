<?php

namespace ICanBoogie\Validate;

/**
 * Validator options.
 */
interface ValidatorOptions
{
    /**
     * A custom error message, which overrides the validator default message.
     */
    public const OPTION_MESSAGE = 'message';

    /**
     * The validator is used only if the callable defined by this option returns `true`.
     */
    public const OPTION_IF = 'if';

    /**
     * The validator is skipped if the callable defined by this option returns `true`.
     */
    public const OPTION_UNLESS = 'unless';

    /**
     * If `true`, the validation of a value stops after an error.
     */
    public const OPTION_STOP_ON_ERROR = 'stop_on_error';
}
