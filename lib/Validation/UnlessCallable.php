<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Validation;

use ICanBoogie\Validate\Context;

/**
 * Callable interface for the {@link ValidatorOptions::OPTION_UNLESS} option.
 */
interface UnlessCallable
{
	/**
	 * Whether the validator should be skipped.
	 *
	 * @param Context $context
	 *
	 * @return bool `true` if the validator should be skipped, `false` otherwise.
	 */
	public function __invoke(Context $context);
}
