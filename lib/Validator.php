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

interface Validator extends ValidatorOptions
{
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
	 * @param mixed $value
	 * @param array $options
	 * @param callable $error
	 */
	public function validate($value, array $options, callable $error);
}
