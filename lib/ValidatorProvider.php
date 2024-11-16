<?php

namespace ICanBoogie\Validate;

/**
 * Provides validators.
 */
interface ValidatorProvider
{
    /**
     * Returns a validator.
     *
     * @param string|class-string<Validator> $class_or_alias The class or alias of the validator.
     *
     * @throws UndefinedValidator if the validator is not defined.
     */
    public function __invoke(string $class_or_alias): Validator;
}
