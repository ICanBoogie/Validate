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
abstract class ValidatorTestCase extends \PHPUnit\Framework\TestCase
{
	const VALIDATOR_CLASS = "";

	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * @var Context
	 */
	protected $context;

	protected function setUp(): void
	{
		$class = static::VALIDATOR_CLASS;
		$this->validator = new $class;
		$this->context = new Context;
	}

	/**
	 * @dataProvider provide_test_valid_values
	 *
	 * @param mixed $value
	 * @param mixed $params
	 * @param string|null $value_type
	 */
	public function test_valid_values($value, $params = null, $value_type = null)
	{
		$this->context->validator_params = $this->validator->normalize_params($params ?: []);
		$this->assertTrue($this->validator->validate($value, $this->context));

		if ($value_type)
		{
			$this->assertEquals($value_type, $this->context->message_args[ComparisonValidatorAbstract::MESSAGE_ARG_VALUE_TYPE]);
		}
	}

	/**
	 * @return array
	 */
	abstract public function provide_test_valid_values();

	/**
	 * @dataProvider provide_test_invalid_values
	 *
	 * @param mixed $value
	 * @param mixed $params
	 * @param string|null $value_type
	 */
	public function test_invalid_values($value, $params = null, $value_type = null)
	{
		$this->context->validator_params = $this->validator->normalize_params($params ?: []);
		$this->assertFalse($this->validator->validate($value, $this->context));

		if ($value_type)
		{
			$this->assertEquals($value_type, $this->context->message_args[ComparisonValidatorAbstract::MESSAGE_ARG_VALUE_TYPE]);
		}
	}

	/**
	 * @return mixed[]
	 */
	abstract public function provide_test_invalid_values(): array;
}
