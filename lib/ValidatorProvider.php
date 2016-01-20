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
 * Provides validators.
 */
interface ValidatorProvider
{
	/**
	 * Returns a validator.
	 *
	 * @param string $class_or_alias The class or alias of the validator.
	 *
	 * @return Validator
	 */
	public function __invoke($class_or_alias);
}
