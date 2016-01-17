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

class Validations implements ValidatorOptions
{
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
	 * @param array $validations
	 * @param callable|ValidatorProvider $validator_provider
	 * @param callable|MessageFormatter $message_formatter
	 */
	public function __construct(array $validations, callable $validator_provider = null, callable $message_formatter = null)
	{
		$this->validator_provider = $validator_provider ?: new BasicValidatorProvider;
		$this->message_formatter = $message_formatter ?: new BasicMessageFormatter;

		foreach ($validations as $field => $validators)
		{
			if (is_string($validators))
			{
				$validators = $this->resolve_validators($validators);
			}

			foreach ($validators as $validator_name => $options)
			{
				$this->validates_with($field, $validator_name, $options);
			}
		}
	}

	/**
	 * Defines a validation type for a field.
	 *
	 * @param string $field
	 * @param string $validator_name
	 * @param array $options
	 *
	 * @return $this
	 */
	public function validates_with($field, $validator_name, array $options)
	{
		$this->validations[$field][$validator_name] = $options;

		return $this;
	}

	/**
	 * @param ValueReader $reader
	 *
	 * @return array
	 */
	public function validate(ValueReader $reader)
	{
		$errors = [];
		$attribute = null;
		$value = null;
		$validator = null;
		$options = [];

		$context = new Context($attribute, $reader);
		$context->attribute = &$attribute;
		$context->value = &$value;
		$context->validator = &$validator;
		$context->errors = &$errors;

		$error = function($message = null, $args = []) use ($context) {

			$context->errors[$context->attribute][] = $this->format_message(
				$message ?: $message = $this->resolve_message($context->options, $context->validator),
				$args + [ 'value' => $context->value, 'attribute' => $context->attribute ]
			);

		};

		foreach ($this->validations as $attribute => $validators)
		{
			foreach ($validators as $validator_name => $options)
			{
				if ($this->should_skip($options))
				{
					continue;
				}

				$value = $reader->read($attribute);
				$validator = $this->resolve_validator($validator_name);
				$context->options = $this->normalize_options($validator, $options);
				$validator->validate($value, $error, $context);

				if ($this->should_stop($context))
				{
					break;
				}
			}
		}

		return $errors;
	}

	/**
	 * Whether the validator should be skipped.
	 *
	 * @param array $options
	 *
	 * @return bool
	 */
	protected function should_skip(array $options)
	{
		/* @var $if callable */
		$if = empty($options[self::OPTION_IF]) ? null : $options[self::OPTION_IF];

		if ($if && !$if())
		{
			return true;
		}

		/* @var $unless callable */
		$unless = empty($options[self::OPTION_UNLESS]) ? null : $options[self::OPTION_UNLESS];

		if ($unless && $unless())
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
		if (empty($context->options[self::OPTION_STOP_ON_ERROR]))
		{
			return false;
		}

		return !empty($context->errors[$context->attribute]);
	}

	/**
	 * Resolves encoded validators into an array of validators.
	 *
	 * @param string $encoded_validators
	 *
	 * @return array An array of key/value pairs where _key_ if the name of a validator and
	 * _value_ its validation options.
	 */
	protected function resolve_validators($encoded_validators)
	{
		$validators = [];

		foreach (explode('|', $encoded_validators) as $encoded_validator)
		{
			list($validator_name, $options) = explode(':', $encoded_validator, 2) + [ 1 => null ];

			$validators[$validator_name] = $options === null ? [] : explode(',', $options);
		}

		return $validators;
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
	 * Normalizes validator options.
	 *
	 * @param Validator $validator
	 * @param array $options
	 *
	 * @return array
	 */
	protected function normalize_options(Validator $validator, $options)
	{
		return $validator->normalize_options($options);
	}

	/**
	 * Resolves error message from options or validator.
	 *
	 * @param array $options
	 * @param Validator $validator
	 *
	 * @return string
	 */
	protected function resolve_message(array $options, Validator $validator)
	{
		return empty($options[self::OPTION_MESSAGE])
			? $validator::DEFAULT_MESSAGE
			: $options[self::OPTION_MESSAGE];
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
