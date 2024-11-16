<?php

namespace ICanBoogie\Validate\Reader;

/**
 * A {@see Reader} adapter for an object.
 */
class ObjectAdapter extends AbstractAdapter
{
    /**
     * If the property is not set, `null` is returned.
     *
     * @inheritdoc
     */
    public function read(string $name): mixed
    {
        return $this->source->$name ?? null;
    }
}
