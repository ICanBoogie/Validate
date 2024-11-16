<?php

namespace ICanBoogie\Validate;

/**
 * An interface for validators.
 */
interface Validator extends ValidatorOptions
{
    /**
     * Validator alias.
     */
    public const ALIAS = null;

    /**
     * Default error message.
     */
    public const DEFAULT_MESSAGE = "is not valid";

    /**
     * Index name of a message `attribute` argument.
     */
    public const MESSAGE_ARG_ATTRIBUTE = 'attribute';

    /**
     * Index name of message `value` argument.
     */
    public const MESSAGE_ARG_VALUE = 'value';

    /**
     * Index name of a message `validator` argument.
     */
    public const MESSAGE_ARG_VALIDATOR = 'validator';

    /**
     * Normalize parameters and options.
     *
     * @param array<int|string, mixed> $params
     *
     * @return array<int|string, mixed>
     */
    public function normalize_params(array $params): array;

    /**
     * Validates a value.
     */
    public function validate(mixed $value, Context $context): bool;
}
