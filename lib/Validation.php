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

use ICanBoogie\Validate\ValidatorProvider\BuiltinValidatorProvider;

/**
 * Validates data against a set of rules.
 */
class Validation implements ValidatorOptions
{
	const SERIALIZED_STOP_ON_ERROR_SUFFIX = '!';
	const SERIALIZED_VALIDATION_SEPARATOR = '|';
	const SERIALIZED_ALIAS_SEPARATOR = ':';
	const SERIALIZED_PARAM_SEPARATOR = ',';

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
			/* @var $attribute string */

			$context->attribute = $attribute;

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
		foreach ($validators as $class_or_alias => $validator_params)
		{
			$context->value = $value = $context->value($attribute);
			$context->validator = $validator = $this->create_validator($class_or_alias);
			$context->validator_params = $validator->normalize_params($validator_params);
			$context->message = $validator::DEFAULT_MESSAGE;
			$context->message_args = [

				'value' => $value,
				'attribute' => $attribute

			];

			if ($this->should_skip($context))
			{
				return;
			}

			if (!$validator->validate($value, $context))
			{
				$this->error($context);
			}

			if ($this->should_stop($context))
			{
				break;
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

			$params = $params === null ? [] : explode(',', $params);

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
	 * Creates a validator.
	 *
	 * @param string $class_or_alias The class or alias of the validator.
	 *
	 * @return Validator
	 */
	protected function create_validator($class_or_alias)
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
