<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate;

use ICanBoogie\Validate\Validator\Required;
use ICanBoogie\Validate\ValidatorProvider\BuiltinValidatorProvider;

/**
 * Validates data against a set of rules.
 */
class Validation implements ValidatorOptions
{
	const SERIALIZED_STOP_ON_ERROR_SUFFIX = '!';
	const SERIALIZED_VALIDATION_SEPARATOR = '|';
	const SERIALIZED_ALIAS_SEPARATOR = ':';
	const SERIALIZED_PARAM_SEPARATOR = ';';

	/**
	 * @var array
	 */
	protected $validations = [];

	/**
	 * @var ValidatorProvider|callable
	 */
	private $validator_provider;

	/**
	 * @param array $rules Validation rules.
	 * @param ValidatorProvider|callable $validator_provider
	 */
	public function __construct(array $rules, callable $validator_provider = null)
	{
		$this->validator_provider = $validator_provider ?: new BuiltinValidatorProvider;

		$this->validates($rules);
	}

	/**
	 * Defines validation rules.
	 *
	 * **Note:** The specified rules may override previously defined rules for the same attributes.
	 *
	 * @param array $rules
	 *
	 * @return $this
	 */
	public function validates(array $rules)
	{
		foreach ($rules as $attribute => $validations)
		{
			if (is_string($validations))
			{
				$validations = $this->unserialize_validations($validations);
			}

			foreach ($validations as $class_or_alias => $params)
			{
				$this->validates_with($attribute, $class_or_alias, $params);
			}
		}

		return $this;
	}

	/**
	 * Defines validation for an attribute.
	 *
	 * @param string $attribute The attribute to validate.
	 * @param string $class_or_alias The class name or alias of the validator.
	 * @param array $params The validator parameters and options.
	 *
	 * @return $this
	 */
	public function validates_with($attribute, $class_or_alias, array $params)
	{
		$this->validations[$attribute][$class_or_alias] = $params;

		return $this;
	}

	/**
	 * Validates data.
	 *
	 * @param Reader $reader
	 *
	 * @return ValidationErrors|array Returns a {@link ValidationErrors} instance if there are
	 * validation errors, an empty array otherwise.
	 */
	public function validate(Reader $reader)
	{
		$context = $this->create_context($reader);

		foreach ($this->validations as $attribute => $validators)
		{
			$context->attribute = $attribute;
			$context->value = $value = $context->value($attribute);

			$validators = $this->resolve_validators($validators, $contains_required);

			if (!$contains_required && Required::is_empty($value))
			{
				continue;
			}

			$this->validate_attribute($attribute, $validators, $context);
		}

		return $context->errors ? new ValidationErrors($context->errors) : [];
	}

	/**
	 * Validates an attribute.
	 *
	 * @param string $attribute
	 * @param array $validators
	 * @param Context $context
	 */
	protected function validate_attribute($attribute, array $validators, Context $context)
	{
		/* @var $validator Validator */
		/* @var $validator_params array */

		foreach ($validators as list($validator, $validator_params))
		{
			$this->prepare_context($context, $attribute, $validator, $validator_params);

			if ($this->should_skip($context))
			{
				continue;
			}

			if (!$validator->validate($context->value, $context))
			{
				$this->error($context);
			}

			if ($this->should_stop($context))
			{
				return;
			}
		}
	}

	/**
	 * Asserts that data is valid.
	 *
	 * @param Reader $reader
	 *
	 * @throws ValidationFailed if the validation failed.
	 */
	public function assert(Reader $reader)
	{
		$errors = $this->validate($reader);

		if ($errors instanceof ValidationErrors)
		{
			throw new ValidationFailed($errors);
		}
	}

	/**
	 * Creates a validation context.
	 *
	 * @param Reader $reader
	 *
	 * @return Context
	 */
	protected function create_context(Reader $reader)
	{
		$context = new Context;
		$context->reader = $reader;

		return $context;
	}

	/**
	 * @param Context $context
	 * @param string $attribute
	 * @param Validator $validator
	 * @param array $validator_params
	 */
	protected function prepare_context(Context $context, $attribute, Validator $validator, array $validator_params)
	{
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
	 *
	 * @param Context $context
	 *
	 * @return bool
	 */
	protected function should_skip(Context $context)
	{
		/* @var $if Validation\IfCallable|callable */
		/* @var $unless Validation\UnlessCallable|callable */

		$if = $context->option(self::OPTION_IF);
		$unless = $context->option(self::OPTION_UNLESS);

		return ($if && !$if($context)) || ($unless && $unless($context));
	}

	/**
	 * Whether validation for an attribute should stop.
	 *
	 * @param Context $context
	 *
	 * @return bool
	 */
	protected function should_stop(Context $context)
	{
		if (!$context->option(self::OPTION_STOP_ON_ERROR))
		{
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
	protected function unserialize_validations($serialized_validations)
	{
		$validations = [];

		foreach (explode(self::SERIALIZED_VALIDATION_SEPARATOR, $serialized_validations) as $serialized_alias_and_params)
		{
			list($alias, $params) = explode(self::SERIALIZED_ALIAS_SEPARATOR, $serialized_alias_and_params, 2) + [ 1 => null ];

			$params = $params === null ? [] : explode(self::SERIALIZED_PARAM_SEPARATOR, $params);

			if (substr($alias, -1) === self::SERIALIZED_STOP_ON_ERROR_SUFFIX)
			{
				$params[self::OPTION_STOP_ON_ERROR] = true;
				$alias = substr($alias, 0, -1);
			}

			$validations[$alias] = $params;
		}

		return $validations;
	}

	/**
	 * @param array $validators
	 * @param bool $contains_required A reference to a variable to will get a boolean whether the
	 * validators contains a {@link Required} validator.
	 *
	 * @return array
	 */
	protected function resolve_validators(array $validators, &$contains_required = false)
	{
		$contains_required = false;

		array_walk($validators, function (&$params, $class_or_alias) use (&$contains_required) {

			$validator = $this->resolve_validator($class_or_alias);

			if ($validator instanceof Required)
			{
				$contains_required = true;
			}

			$params = [ $validator, $params ];

		});

		return $validators;
	}

	/**
	 * Creates a validator.
	 *
	 * @param string $class_or_alias The class or alias of the validator.
	 *
	 * @return Validator
	 */
	protected function resolve_validator($class_or_alias)
	{
		$provider = $this->validator_provider;

		return $provider($class_or_alias);
	}

	/**
	 * Creates an error message.
	 *
	 * @param string $message
	 * @param array $args
	 *
	 * @return Message
	 */
	protected function create_message($message, array $args)
	{
		return new Message($message, $args);
	}

	/**
	 * Adds an error to the collection.
	 *
	 * @param Context $context
	 */
	protected function error(Context $context)
	{
		$context->errors[$context->attribute][] = $this->create_message(
			$context->option(self::OPTION_MESSAGE) ?: $context->message,
			$context->message_args);
	}
}
