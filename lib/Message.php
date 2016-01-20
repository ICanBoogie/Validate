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
 * Representation of an error message.
 */
class Message
{
	/**
	 * Message pattern.
	 *
	 * @var string
	 */
	public $message;

	/**
	 * Formatting arguments.
	 *
	 * @var array
	 */
	public $args;

	/**
	 * @param string $message
	 * @param array $args
	 */
	public function __construct($message, array $args = [])
	{
		$this->message = $message;
		$this->args = $args;
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return Render::render_message($this);
	}
}
