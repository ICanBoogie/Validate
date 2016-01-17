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
 * An interface for validator classes.
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
	 * Normalize options.
	 *
	 * @param array $options
	 *
	 * @return array Normalized options.
	 */
	public function normalize_options(array $options);

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
