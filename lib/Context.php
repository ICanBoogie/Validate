<?php

namespace ICanBoogie\Validate;

/**
 * Representation of a validation context.
 */
class Context
{
    /**
     * The attribute being validated.
     */
    public string $attribute;

    /**
     * The value of the attribute being validated.
     */
    public mixed $value;

    /**
     * A reader adapter.
     */
    public Reader $reader;

    /**
     * The current validator.
     */
    public Validator $validator;

    /**
     * The validator parameters.
     *
     * @var array<string, mixed>
     */
    public array $validator_params = [];

    /**
     * The possible error message for the current validator.
     *
     * @var string
     */
    public string $message;

    /**
     * The arguments for the possible error message.
     *
     * @var array<string, mixed>
     */
    public array $message_args = [];

    /**
     * The collected errors.
     *
     * @var array<string, array<Message>>
     */
    public array $errors = [];

    /**
     * Retrieves a value from the reader adapter.
     *
     * @return mixed The value, or `null` if it is not defined.
     */
    public function value(string $name): mixed
    {
        return $this->reader->read($name);
    }

    /**
     * Retrieves a parameter from the validator parameters.
     *
     * @throws ParameterIsMissing if the parameter is not set.
     */
    public function param(string $name): mixed
    {
        if (!isset($this->validator_params[$name])) {
            // @TODO: FIXME
            throw new ParameterIsMissing(/*get_class($this->validator) . */ '::PARAM_' . strtoupper($name));
        }

        return $this->validator_params[$name];
    }

    /**
     * Retrieves an option from the validator parameters.
     *
     * @return mixed The option value or `null` if it is not defined.
     */
    public function option(string $name, mixed $default = null): mixed
    {
        return $this->validator_params[$name] ?? $default;
    }
}
