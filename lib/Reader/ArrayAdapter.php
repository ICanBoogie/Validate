<?php

namespace ICanBoogie\Validate\Reader;

/**
 * A {@see Reader} adapter for an array or an instance of {@see ArrayAccess}.
 */
class ArrayAdapter extends AbstractAdapter
{
    /**
     * If the offset doesn't exist, `null` is returned.
     *
     * @inheritdoc
     */
    public function read(string $name): mixed
    {
        return $this->source[$name] ?? null;
    }
}
