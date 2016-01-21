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
	 * Message format.
	 *
	 * @var string
	 */
	public $format;

	/**
	 * Formatting arguments.
	 *
	 * @var array
	 */
	public $args;

	/**
	 * @param string $format
	 * @param array $args
	 */
	public function __construct($format, array $args = [])
	{
		$this->format = $format;
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
