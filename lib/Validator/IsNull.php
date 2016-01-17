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

/**
 * Validates that a value is null.
 */
class IsNull extends AbstractValidator
{
	const ALIAS = 'is-null';
	const DEFAULT_MESSAGE = "should be null";

	/**
	 * @inheritdoc
	 */
	public function validate($value, array $options, callable $error)
	{
		if ($value !== null)
		{
			$error();
		}
	}
}
