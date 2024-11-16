<?php

namespace ICanBoogie\Validate\Reader;

/**
 * A {@see Reader} adapter for `$_GET`, `$_POST`, or `$_REQUEST`.
 */
class RequestAdapter extends ArrayAdapter
{
    /**
     * If a value is a string, and once trimmed is empty, `null` is returned.
     *
     * @inheritdoc
     */
    public function read(string $name): mixed
    {
        $value = parent::read($name);

        if (is_string($value) && trim($value) === '') {
            return null;
        }

        return $value;
    }
}
