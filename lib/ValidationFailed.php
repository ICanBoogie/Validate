<?php

namespace ICanBoogie\Validate;

use LogicException;
use Throwable;

/**
 * Exception throw when asserting a validation failed.
 *
 * @property-read ValidationErrors $errors
 */
class ValidationFailed extends LogicException
{
    public const DEFAULT_MESSAGE = "Validation failed.";

    public function __construct(
        public readonly ValidationErrors $errors,
        ?Throwable $previous = null,
    ) {
        parent::__construct($this->format_message($errors), previous: $previous);
    }

    protected function format_message(ValidationErrors $errors): string
    {
        $message = static::DEFAULT_MESSAGE . "\n";

        foreach ($errors as $attribute => $attribute_errors) {
            foreach ($attribute_errors as $error) {
                $message .= "\n- $attribute: $error";
            }
        }

        return $message;
    }
}
