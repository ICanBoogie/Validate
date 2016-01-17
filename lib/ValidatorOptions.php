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
 * Validator options.
 */
interface ValidatorOptions
{
	/**
	 * A custom error message, which overrides the validator default message.
	 */
	const OPTION_MESSAGE = 'message';

	/**
	 * The validator is used only if the callable defined by this option returns `true`.
	 */
	const OPTION_IF = 'if';

	/**
	 * The validator is skipped if the callable defined by this option returns `true`.
	 */
	const OPTION_UNLESS = 'unless';

	/**
	 * If `true`, the validation of a value stops after an error.
	 */
	const OPTION_STOP_ON_ERROR = 'stop_on_error';
}
