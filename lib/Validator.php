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
