<?php

namespace ICanBoogie\Validate;

/**
 * Representation of an error message.
 */
readonly class Message
{
    /**
     * @param mixed[] $args
     */
    public function __construct(
        public string $format,
        public array $args = []
    ) {
    }

    public function __toString()
    {
        return Render::render_message($this);
    }
}
