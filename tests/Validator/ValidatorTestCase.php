<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Validator;

abstract class ValidatorTestCase extends \PHPUnit_Framework_TestCase
{
	const VALIDATOR_CLASS = "";

	/**
	 * @var Validator
	 */
	private $validator;

	/**
	 * @var callable
	 */
	private $error;
	private $error_was_invoked = false;

	public function setUp()
	{
		$class = static::VALIDATOR_CLASS;
		$this->validator = new $class;
		$this->error_was_invoked = false;
		$this->error = function() {

			$this->error_was_invoked = true;

		};
	}

	/**
	 * @dataProvider provide_test_valid_values
	 *
	 * @param mixed $value
	 * @param array $options
	 */
	public function test_valid_values($value, $options = [])
	{
		$options = $this->validator->normalize_options($options);
		$this->validator->validate($value, $options, $this->error);
		$this->assertFalse($this->error_was_invoked);
	}

	abstract public function provide_test_valid_values();

	/**
	 * @dataProvider provide_test_invalid_values
	 *
	 * @param mixed $value
	 * @param array $options
	 */
	public function test_invalid_values($value, $options = [])
	{
		$options = $this->validator->normalize_options($options);
		$this->validator->validate($value, $options, $this->error);
		$this->assertTrue($this->error_was_invoked);
	}

	abstract public function provide_test_invalid_values();
}
