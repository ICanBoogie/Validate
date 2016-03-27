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

use ICanBoogie\ErrorCollection;

/**
 * @small
 */
class ValidationErrorsTest extends \PHPUnit_Framework_TestCase
{
	public function test_from()
	{
		$source = [ uniqid() => [ uniqid() => new Message(uniqid()) ] ];
		$errors = ValidationErrors::from($source);
		$this->assertSame($source, $errors->to_array());
	}

	public function test_new()
	{
		$source = [ uniqid() => [ uniqid() => new Message(uniqid()) ] ];
		$errors = new ValidationErrors($source);
		$this->assertSame($source, $errors->to_array());
	}

	public function test_clear()
	{
		$source = [ uniqid() => [ uniqid() => new Message(uniqid()) ] ];
		$errors = new ValidationErrors($source);
		$this->assertSame($source, $errors->to_array());
		$this->assertEmpty($errors->clear()->to_array());
	}

	public function test_to_error_collection()
	{
		$format = uniqid();
		$args = [ uniqid() => uniqid() ];
		$source = [ uniqid() => [ uniqid() => new Message($format, $args) ] ];
		$errors = new ValidationErrors($source);
		$collection = $errors->to_error_collection();
		$this->assertInstanceOf(ErrorCollection::class, $collection);

		/* @var $error \ICanBoogie\Error */

		foreach ($collection as $error)
		{
			$this->assertSame($format, $error->format);
			$this->assertSame($args, $error->args);
		}
	}
}
