<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Validator;

/**
 * Abstract validator.
 */
abstract class AbstractValidator implements Validator
{
	/**
	 * @inheritdoc
	 */
	public function normalize_options(array $options)
	{
		return $options;
	}

	/**
	 * @inheritdoc
	 */
	abstract public function validate($value, array $options, callable $error);
}
