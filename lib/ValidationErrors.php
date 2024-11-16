<?php

namespace ICanBoogie\Validate;

use ArrayObject;
use ICanBoogie\ErrorCollection;

/**
 * Representation of validation errors.
 *
 * @extends ArrayObject<string, Message[]>
 */
final class ValidationErrors extends ArrayObject
{
    /**
     * Creates a new instance with the specified errors.
     *
     * @param array<string, Message[]> $errors
     */
    public static function from(array $errors): self
    {
        return new self($errors);
    }

    /**
     * Returns a copy of the instance.
     *
     * @return array<string, Message[]>
     */
    public function to_array(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * Returns validation errors as an {@see ErrorCollection}.
     */
    public function to_error_collection(): ErrorCollection
    {
        $collection = new ErrorCollection();

        foreach ($this as $attribute => $messages) {
            foreach ($messages as $message) {
                $collection->add($attribute, $message->format, $message->args);
            }
        }

        return $collection;
    }

    /**
     * Clears the instance.
     *
     * @return $this
     */
    public function clear(): self
    {
        $this->exchangeArray([]);

        return $this;
    }
}
