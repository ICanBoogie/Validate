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

use ICanBoogie\Validate\MessageFormatter\BuiltinMessageFormatter;
use ICanBoogie\Validate\ValidatorProvider\BuiltinValidatorProvider;

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
	 * @var callable|ValidatorProvider
	 */
	private $validator_provider;

	/**
	 * @var callable|MessageFormatter
	 */
	private $message_formatter;

	/**
	 * @param array $rules Validation rules.
	 * @param callable|ValidatorProvider $validator_provider
	 * @param callable|MessageFormatter $message_formatter
	 */
	public function __construct(array $rules, callable $validator_provider = null, callable $message_formatter = null)
	{
		$this->validator_provider = $validator_provider ?: new BuiltinValidatorProvider;
		$this->message_formatter = $message_formatter ?: new BuiltinMessageFormatter;

		$this->validates($rules);
	}

	/**
	 * Defines validation rules.
	 *
	 * **Note:** The specified rules may override previously defined rules for a same attribute.
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
	 * @param ValueReader $reader
	 *
	 * @return array
	 */
	public function validate(ValueReader $reader)
	{
		$context = $this->create_context($reader);

		foreach ($this->validations as $attribute => $validators)
		{
			foreach ($validators as $class_or_alias => $validator_params)
			{
				$this->validate_attribute($context, $attribute, $class_or_alias, $validator_params);

				if ($this->should_stop($context))
				{
					break;
				}
			}
		}

		return $context->errors ? new ValidationErrors($context->errors) : [];
	}

	/**
	 * Validates an attribute.
	 *
	 * @param Context $context Validation context.
	 * @param string $attribute The attribute to validate.
	 * @param string $class_or_alias Validator class or alias.
	 * @param array $params Validator params.
	 */
	protected function validate_attribute(Context $context, $attribute, $class_or_alias, array $params)
	{
		$context->attribute = $attribute;
		$context->value = $value = $context->value($attribute);
		$context->validator = $validator = $this->resolve_validator($class_or_alias);
		$context->validator_params = $this->normalize_validator_params($validator, $params);
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
			$this->push_error($context);
		}
	}

	/**
	 * @param ValueReader $reader
	 *
	 * @throws ValidationFailed if the validation failed.
	 */
	public function assert(ValueReader $reader)
	{
		$errors = $this->validate($reader);

		if ($errors instanceof ValidationErrors)
		{
			throw new ValidationFailed($errors);
		}
	}

	/**
	 * Creates a validations context.
	 *
	 * @param ValueReader $reader
	 *
	 * @return Context
	 */
	protected function create_context(ValueReader $reader)
	{
		$context = new Context;
		$context->values = $reader;

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
	 * Whether validations for a field should stop.
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
	 * Resolves a validator from its name.
	 *
	 * @param string $class_or_alias
	 *
	 * @return Validator
	 */
	protected function resolve_validator($class_or_alias)
	{
		$provider = $this->validator_provider;

		return $provider($class_or_alias);
	}

	/**
	 * Normalizes validator params.
	 *
	 * @param Validator $validator
	 * @param array $params
	 *
	 * @return array
	 */
	protected function normalize_validator_params(Validator $validator, $params)
	{
		return $validator->normalize_params($params);
	}

	/**
	 * Pushes an error to the collection.
	 *
	 * @param Context $context
	 */
	protected function push_error(Context $context)
	{
		$context->errors[$context->attribute][] = $this->format_message(
			$context->option(self::OPTION_MESSAGE) ?: $context->message,
			$context->message_args);
	}

	/**
	 * Formats a message with its arguments.
	 *
	 * @param string $message
	 * @param array $args
	 *
	 * @return string|mixed
	 */
	protected function format_message($message, array $args)
	{
		$formatter = $this->message_formatter;

		return $formatter($message, $args);
	}
}
