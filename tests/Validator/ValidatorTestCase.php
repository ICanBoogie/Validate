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

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\Validator;

/**
 * @small
 */
abstract class ValidatorTestCase extends \PHPUnit_Framework_TestCase
{
	const VALIDATOR_CLASS = "";

	/**
	 * @var Validator
	 */
	private $validator;

	/**
	 * @var Context
	 */
	private $context;

	public function setUp()
	{
		$class = static::VALIDATOR_CLASS;
		$this->validator = new $class;
		$this->context = new Context;
	}

	/**
	 * @dataProvider provide_test_valid_values
	 *
	 * @param mixed $value
	 * @param array $params
	 */
	public function test_valid_values($value, $params = [])
	{
		$this->context->validator_params = $this->validator->normalize_params($params);
		$this->assertTrue($this->validator->validate($value, $this->context));
	}

	abstract public function provide_test_valid_values();

	/**
	 * @dataProvider provide_test_invalid_values
	 *
	 * @param mixed $value
	 * @param array $params
	 */
	public function test_invalid_values($value, $params = [])
	{
		$this->context->validator_params = $this->validator->normalize_params($params);
		$this->assertFalse($this->validator->validate($value, $this->context));
	}

	abstract public function provide_test_invalid_values();
}
