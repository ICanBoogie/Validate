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
 * Formats a message with its arguments.
 */
interface MessageFormatter
{
	/**
	 * Formats a message with its arguments.
	 *
	 * @param string $message Message template.
	 * @param array $args Message arguments.
	 *
	 * @return string|mixed
	 */
	public function __invoke($message, array $args);
}
