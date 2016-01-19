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

class ValidationErrorsTest extends \PHPUnit_Framework_TestCase
{
	public function test_from()
	{
		$source = [ uniqid() => [ uniqid() => uniqid() ] ];
		$errors = ValidationErrors::from($source);
		$this->assertSame($source, $errors->to_array());
	}

	public function test_new()
	{
		$source = [ uniqid() => [ uniqid() => uniqid() ] ];
		$errors = new ValidationErrors($source);
		$this->assertSame($source, $errors->to_array());
	}

	public function test_clear()
	{
		$source = [ uniqid() => [ uniqid() => uniqid() ] ];
		$errors = new ValidationErrors($source);
		$this->assertSame($source, $errors->to_array());
		$this->assertEmpty($errors->clear()->to_array());
	}
}
