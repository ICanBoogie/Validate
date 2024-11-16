<?php

namespace ICanBoogie\Validate\Reader;

use ICanBoogie\Validate\Reader;

/**
 * An abstract {@see Reader} adapter.
 */
abstract class AbstractAdapter implements Reader
{
    public function __construct(
        protected readonly mixed $source,
    ) {
    }
}
