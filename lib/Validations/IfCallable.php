<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Validations;

use ICanBoogie\Validate\Context;

/**
 * Callable interface for the {@link ValidatorOptions::OPTION_IF} option.
 */
interface IfCallable
{
	/**
	 * Whether the validator should be used.
	 *
	 * @param Context $context
	 *
	 * @return bool `true` if the validator should be used, `false` otherwise.
	 */
	public function __invoke(Context $context);
}
