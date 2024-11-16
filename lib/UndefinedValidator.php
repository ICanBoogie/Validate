<?php

namespace ICanBoogie\Validate;

use LogicException;
use Throwable;

/**
 * Exception throw if a validator is not defined.
 */
class UndefinedValidator extends LogicException
{
    /**
     * @param string|class-string $class_or_alias
     * @param Throwable|null $previous
     */
    public function __construct(
        public readonly string $class_or_alias,
        ?Throwable $previous = null
    ) {
        parent::__construct($this->format_message($class_or_alias), previous: $previous);
    }

    /**
     * @param string|class-string $class_or_alias
     */
    protected function format_message(string $class_or_alias): string
    {
        return "Undefined validator: $class_or_alias.";
    }
}
