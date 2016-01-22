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

/**
 * An interface for validators.
 */
interface Validator extends ValidatorOptions
{
	/**
	 * Validator alias.
	 */
	const ALIAS = null;

	/**
	 * Default error message.
	 */
	const DEFAULT_MESSAGE = "is not valid";

	/**
	 * Index name of message `attribute` argument.
	 */
	const MESSAGE_ARG_ATTRIBUTE = 'attribute';

	/**
	 * Index name of message `value` argument.
	 */
	const MESSAGE_ARG_VALUE = 'value';

	/**
	 * Index name of message `validator` argument.
	 */
	const MESSAGE_ARG_VALIDATOR = 'validator';

	/**
	 * Normalize parameters and options.
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	public function normalize_params(array $params);

	/**
	 * Validate a value.
	 *
	 * @param mixed $value
	 * @param Context $context
	 *
	 * @return bool
	 */
	public function validate($value, Context $context);
}
