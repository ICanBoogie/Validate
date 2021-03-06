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

class UndefinedValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function test_exception()
	{
		$class_or_alias = uniqid();
		$previous = new \Exception();
		$exception = new UndefinedValidator($class_or_alias, $previous);

		$this->assertSame($class_or_alias, $exception->class_or_alias);
		$this->assertSame($previous, $exception->getPrevious());
	}

	/**
	 * @expectedException \LogicException
	 */
	public function test_should_throw_exception_on_getting_undefined_property()
	{
		$exception = new UndefinedValidator(uniqid());
		$exception->{ uniqid() };
	}
}
