<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is of a specific type.
 */
class Type extends ValidatorAbstract
{
    public const ALIAS = 'type';
    public const DEFAULT_MESSAGE = "should be of type {type}";

    public const PARAM_TYPE = 'type';

    /**
     * Mapping for `is_*` and `ctype_*` functions.
     */
    private const MAPPING = [

        'is' => [
            'array',
            'bool',
            'double',
            'float',
            'int',
            'integer',
            'long',
            'null',
            'numeric',
            'object',
            'real',
            'resource',
            'scalar',
            'string',
        ],

        'ctype' => [
            'alnum',
            'alpha',
            'cntrl',
            'digit',
            'graph',
            'lower',
            'print',
            'punct',
            'space',
            'upper',
            'xdigit',
        ],

    ];

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        $context->message_args[self::PARAM_TYPE] = $type = $context->param(self::PARAM_TYPE);
        $callable = $this->resolve_callable($this->normalize_type($type));

        if ($callable) {
            return $callable($value);
        }

        return $value instanceof $type;
    }

    /**
     * @inheritdoc
     */
    protected function get_params_mapping(): array
    {
        return [ self::PARAM_TYPE ];
    }

    /**
     * Normalizes type.
     */
    protected function normalize_type(string $type): string
    {
        $type = strtolower($type);

        if ($type == 'boolean') {
            $type = 'bool';
        }

        return $type;
    }

    /**
     * Resolves callable to validate type.
     */
    protected function resolve_callable(string $type): ?callable
    {
        foreach (self::MAPPING as $prefix => $types) {
            if (in_array($type, $types)) {
                /** @var callable */
                return "{$prefix}_$type";
            }
        }

        return null;
    }
}
