<?php

namespace ICanBoogie\Validate;

use ICanBoogie\Validate\Validator\Required;
use ICanBoogie\Validate\ValidatorProvider\BuiltinValidatorProvider;

/**
 * Validates data against a set of rules.
 */
class Validation implements ValidatorOptions
{
    public const SERIALIZED_STOP_ON_ERROR_SUFFIX = '!';
    public const SERIALIZED_VALIDATION_SEPARATOR = '|';
    public const SERIALIZED_ALIAS_SEPARATOR = ':';
    public const SERIALIZED_PARAM_SEPARATOR = ';';

    /**
     * @var array<string, array<string|class-string, array<string, mixed>>>
     */
    private array $validations = [];

    /**
     * @var ValidatorProvider|callable
     */
    private $validator_provider;

    /**
     * @param array $rules Validation rules.
     */
    public function __construct(array $rules, ValidatorProvider|callable|null $validator_provider = null)
    {
        $this->validator_provider = $validator_provider ?? new BuiltinValidatorProvider();

        $this->validates($rules);
    }

    /**
     * Defines validation rules.
     *
     * **Note**: The specified rules may override previously defined rules for the same attributes.
     *
     * @param array $rules
     *
     * @return $this
     */
    public function validates(array $rules): static
    {
        foreach ($rules as $attribute => $validations) {
            if (is_string($validations)) {
                $validations = $this->unserialize_validations($validations);
            }

            foreach ($validations as $class_or_alias => $params) {
                $this->validates_with($attribute, $class_or_alias, $params);
            }
        }

        return $this;
    }

    /**
     * Defines validation for an attribute.
     *
     * @param string $attribute The attribute to validate.
     * @param string|class-string $class_or_alias The class name or alias of the validator.
     * @param array $params The validator parameters and options.
     *
     * @return $this
     */
    public function validates_with(string $attribute, string $class_or_alias, array $params): static
    {
        $this->validations[$attribute][$class_or_alias] = $params;

        return $this;
    }

    /**
     * Validates data.
     *
     * @param Reader $reader
     *
     * @return ValidationErrors|array Returns a {@see ValidationErrors} instance if there are
     * validation errors, an empty array otherwise.
     */
    public function validate(Reader $reader): array|ValidationErrors
    {
        $context = $this->create_context($reader);

        foreach ($this->validations as $attribute => $validators) {
            $context->attribute = $attribute;
            $context->value = $value = $context->value($attribute);

            $validators = $this->resolve_validators($validators, $contains_required);

            if (!$contains_required && Required::is_empty($value)) {
                continue;
            }

            $this->validate_attribute($attribute, $validators, $context);
        }

        return $context->errors ? new ValidationErrors($context->errors) : [];
    }

    /**
     * Validates an attribute.
     */
    protected function validate_attribute(string $attribute, array $validators, Context $context): void
    {
        /* @var $validator Validator */
        /* @var $validator_params array */

        foreach ($validators as [$validator, $validator_params]) {
            $this->prepare_context($context, $attribute, $validator, $validator_params);

            if ($this->should_skip($context)) {
                continue;
            }

            if (!$validator->validate($context->value, $context)) {
                $this->error($context);
            }

            if ($this->should_stop($context)) {
                return;
            }
        }
    }

    /**
     * Asserts that data is valid.
     *
     * @throws ValidationFailed if the validation failed.
     */
    public function assert(Reader $reader): void
    {
        $errors = $this->validate($reader);

        if ($errors instanceof ValidationErrors) {
            throw new ValidationFailed($errors);
        }
    }

    /**
     * Creates a validation context.
     */
    protected function create_context(Reader $reader): Context
    {
        $context = new Context();
        $context->reader = $reader;

        return $context;
    }

    protected function prepare_context(
        Context $context,
        string $attribute,
        Validator $validator,
        array $validator_params,
    ): void {
        $context->validator = $validator;
        $context->validator_params = $validator->normalize_params($validator_params);
        $context->message = $validator::DEFAULT_MESSAGE;
        $context->message_args = [

            Validator::MESSAGE_ARG_ATTRIBUTE => $attribute,
            Validator::MESSAGE_ARG_VALUE => $context->value,
            Validator::MESSAGE_ARG_VALIDATOR => get_class($validator),

        ];
    }

    /**
     * Whether the validator should be skipped.
     */
    protected function should_skip(Context $context): bool
    {
        /* @var $if Validation\IfCallable|callable */
        /* @var $unless Validation\UnlessCallable|callable */

        $if = $context->option(self::OPTION_IF);
        $unless = $context->option(self::OPTION_UNLESS);

        return ($if && !$if($context)) || ($unless && $unless($context));
    }

    /**
     * Whether validation for an attribute should stop.
     */
    protected function should_stop(Context $context): bool
    {
        if (!$context->option(self::OPTION_STOP_ON_ERROR)) {
            return false;
        }

        return !empty($context->errors[$context->attribute]);
    }

    /**
     * Resolves validations from a string.
     *
     * @param string $serialized_validations
     *
     * @return array An array of key/value pairs where _key_ if the alias of a validator and
     * _value_ its parameters and options.
     */
    protected function unserialize_validations(string $serialized_validations): array
    {
        $validations = [];

        foreach (
            explode(
                self::SERIALIZED_VALIDATION_SEPARATOR,
                $serialized_validations,
            ) as $serialized_alias_and_params
        ) {
            [ $alias, $params ] = explode(
                self::SERIALIZED_ALIAS_SEPARATOR,
                $serialized_alias_and_params,
                2,
            ) + [ 1 => null ];

            $params = $params === null ? [] : explode(self::SERIALIZED_PARAM_SEPARATOR, $params);

            if (substr($alias, -1) === self::SERIALIZED_STOP_ON_ERROR_SUFFIX) {
                $params[self::OPTION_STOP_ON_ERROR] = true;
                $alias = substr($alias, 0, -1);
            }

            $validations[$alias] = $params;
        }

        return $validations;
    }

    /**
     * @param array $validators
     * @param bool $contains_required A reference to a variable will get a boolean whether the
     * validators contains a {@see Required} validator.
     *
     * @return array
     */
    protected function resolve_validators(array $validators, bool|null &$contains_required = false): array
    {
        $contains_required = false;

        array_walk($validators, function (&$params, $class_or_alias) use (&$contains_required) {
            $validator = $this->resolve_validator($class_or_alias);

            if ($validator instanceof Required) {
                $contains_required = true;
            }

            $params = [ $validator, $params ];
        });

        return $validators;
    }

    /**
     * Creates a validator.
     *
     * @param string|class-string $class_or_alias The class or alias of the validator.
     */
    protected function resolve_validator(string $class_or_alias): Validator
    {
        $provider = $this->validator_provider;

        return $provider($class_or_alias);
    }

    /**
     * Creates an error message.
     */
    protected function create_message(string $message, array $args): Message
    {
        return new Message($message, $args);
    }

    /**
     * Adds an error to the collection.
     */
    protected function error(Context $context): void
    {
        $context->errors[$context->attribute][] = $this->create_message(
            $context->option(self::OPTION_MESSAGE) ?: $context->message,
            $context->message_args,
        );
    }
}
