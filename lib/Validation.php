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

use ICanBoogie\Validate\MessageFormatter\BasicMessageFormatter;
use ICanBoogie\Validate\ValidatorProvider\BasicValidatorProvider;

class Validation implements ValidatorOptions
{
	const PREFIX_STOP_ON_ERROR = '!';

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
		$this->validator_provider = $validator_provider ?: new BasicValidatorProvider;
		$this->message_formatter = $message_formatter ?: new BasicMessageFormatter;

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
				$validations = $this->resolve_validations_from_string($validations);
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
		$attribute = null;
		$value = null;
		$validator = null;

		$context = $this->create_context($reader);
		$context->attribute = &$attribute;
		$context->value = &$value;
		$context->validator = &$validator;

		foreach ($this->validations as $attribute => $validators)
		{
			foreach ($validators as $validator_name => $validator_params)
			{
				$value = $reader->read($attribute);
				$validator = $this->resolve_validator($validator_name);

				$context->validator_params = $this->normalize_validator_params($validator, $validator_params);
				$context->message = $validator::DEFAULT_MESSAGE;
				$context->message_args = [

					'value' => $value,
					'attribute' => $attribute

				];

				if ($this->should_skip($context))
				{
					continue;
				}

				if (!$validator->validate($value, $context))
				{
					$this->push_error($context);
				}

				if ($this->should_stop($context))
				{
					break;
				}
			}
		}

		return $context->errors ? new ValidationErrors($context->errors) : [];
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

		$if = $context->option(self::OPTION_IF);

		if ($if && !$if($context))
		{
			return true;
		}

		/* @var $unless Validation\UnlessCallable|callable */

		$unless = $context->option(self::OPTION_UNLESS);

		if ($unless && $unless($context))
		{
			return true;
		}

		return false;
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
	protected function resolve_validations_from_string($serialized_validations)
	{
		$validations = [];

		foreach (explode('|', $serialized_validations) as $serialized_alias_and_params)
		{
			list($alias, $params) = explode(':', $serialized_alias_and_params, 2) + [ 1 => null ];

			$params = $params === null ? [] : explode(',', $params);

			if (substr($alias, -1) === self::PREFIX_STOP_ON_ERROR)
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
	 * @param string $validator_name
	 *
	 * @return Validator
	 */
	protected function resolve_validator($validator_name)
	{
		$provider = $this->validator_provider;

		return $provider($validator_name);
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
