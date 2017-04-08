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
use ICanBoogie\Validate\ParameterIsMissing;

/**
 * @small
 */
class RangeValidatorAbstractTest extends \PHPUnit_Framework_TestCase
{
	public function test_normalize_params()
	{
		$validator = $this
			->getMockBuilder(RangeValidatorAbstract::class)
			->getMockForAbstractClass();

		/* @var $validator RangeValidatorAbstract */

		$min = mt_rand(10, 20);
		$max = mt_rand(30, 40);

		$this->assertSame([

			RangeValidatorAbstract::PARAM_MIN => $min,
			RangeValidatorAbstract::PARAM_MAX => $max,

		], $validator->normalize_params([ $min, $max ]));
	}

	/**
	 * @dataProvider provide_param
	 *
	 * @param array $params
	 * @param string $missing
	 */
	public function test_should_throw_exception_on_missing_param(array $params, $missing)
	{
		$validator = $this
			->getMockBuilder(RangeValidatorAbstract::class)
			->getMockForAbstractClass();

		/* @var $validator RangeValidatorAbstract */

		try
		{
			$context = new Context;
			$context->validator_params = $params;
			$validator->validate(uniqid(), $context);
		}
		catch (ParameterIsMissing $e)
		{
			$this->assertStringEndsWith("::PARAM_$missing", $e->parameter);

			return;
		}

		$this->fail("Expected ParameterIsMissing");
	}

	public function provide_param()
	{
		return [

			[ [ RangeValidatorAbstract::PARAM_MAX => 10 ], 'MIN' ],
			[ [ RangeValidatorAbstract::PARAM_MIN => 10 ], 'MAX' ],

		];
	}

	public function test_message_args()
	{
		$validator = $this
			->getMockBuilder(RangeValidatorAbstract::class)
			->getMockForAbstractClass();

		/* @var $validator RangeValidatorAbstract */

		$context = new Context;
		$min = mt_rand(10, 20);
		$max = mt_rand(30, 40);
		$context->validator_params = [

			RangeValidatorAbstract::PARAM_MIN => $min,
			RangeValidatorAbstract::PARAM_MAX => $max,

		];

		$validator->validate(mt_rand(50, 60), $context);

		$this->assertArrayHasKey(RangeValidatorAbstract::MESSAGE_ARG_MIN, $context->message_args);
		$this->assertArrayHasKey(RangeValidatorAbstract::MESSAGE_ARG_MAX, $context->message_args);
		$this->assertArrayHasKey(RangeValidatorAbstract::MESSAGE_ARG_VALUE_TYPE, $context->message_args);
		$this->assertSame($min, $context->message_args[RangeValidatorAbstract::MESSAGE_ARG_MIN]);
		$this->assertSame($max, $context->message_args[RangeValidatorAbstract::MESSAGE_ARG_MAX]);
		$this->assertSame('integer', $context->message_args[RangeValidatorAbstract::MESSAGE_ARG_VALUE_TYPE]);
	}
}
