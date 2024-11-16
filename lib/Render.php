<?php

namespace ICanBoogie\Validate;

/**
 * Renders messages and values.
 */
class Render
{
    private const RENDER_MAPPING = [

        'NULL' => 'render_null',
        'boolean' => 'render_boolean',
        'array' => 'render_array',
        'object' => 'render_object',

    ];

    /**
     * Renders a message into a string.
     */
    public static function render_message(Message $message): string
    {
        return strtr($message->format, self::build_replacements($message->args));
    }

    /**
     * Renders value type.
     */
    public static function render_type(mixed $value): string
    {
        return gettype($value);
    }

    /**
     * Renders a value into a string.
     */
    public static function render_value(mixed $value): string
    {
        $mapping = self::RENDER_MAPPING;
        $type = gettype($value);

        if (isset($mapping[$type])) {
            $method = $mapping[$type];
            return static::$method($value);
        }

        if (!is_scalar($value)) {
            return static::render_other($value);
        }

        return (string)$value;
    }

    /**
     * Creates a replacement array.
     *
     * @param array<string, mixed> $args
     *
     * @return array<string, mixed>
     */
    protected static function build_replacements(array $args): array
    {
        $replace = [];

        foreach ($args as $arg => $value) {
            $replace['{' . $arg . '}'] = static::render_value($value);
        }

        return $replace;
    }

    /**
     * Renders `null`.
     */
    protected static function render_null(): string
    {
        return 'null';
    }

    /**
     * Renders a boolean.
     *
     * @param bool $value
     */
    protected static function render_boolean($value): string
    {
        return $value === false ? 'false' : 'true';
    }

    /**
     * Renders an array.
     */
    protected static function render_array(array $value): string
    {
        return 'array{' . implode(', ', array_keys($value)) . '}';
    }

    /**
     * Renders an object.
     */
    protected static function render_object(mixed $value): string
    {
        return 'instance of ' . get_class($value);
    }

    /**
     * Renders other types.
     */
    protected static function render_other(mixed $value): string
    {
        return 'type{' . gettype($value) . '}';
    }
}
