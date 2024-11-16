<?php

namespace ICanBoogie\Validate;

use Exception;
use LogicException;
use Throwable;

/**
 * Exception thrown when a required validator parameter is missing.
 */
class ParameterIsMissing extends LogicException
{
    /**
     * @param Exception|null $previous
     */
    public function __construct(
        public readonly string $parameter,
        ?Throwable $previous = null
    ) {
        parent::__construct($this->format_message($parameter), previous: $previous);
    }

    /**
     * Formats exception message.
     */
    protected function format_message(string $parameter): string
    {
        return "Parameter `$parameter` is missing.";
    }
}
