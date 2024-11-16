<?php

namespace ICanBoogie\Validate;

/**
 * An interface to read values from a source.
 */
interface Reader
{
    /**
     * Reads a value from a source.
     */
    public function read(string $name): mixed;
}
