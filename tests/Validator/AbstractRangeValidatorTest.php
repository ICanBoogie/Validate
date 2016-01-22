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
class AbstractRangeValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function test_normalize_params()
	{
		$validator = $this
			->getMockBuilder(AbstractRangeValidator::class)
			->getMockForAbstractClass();

		/* @var $validator AbstractRangeValidator */

		$min = mt_rand(10, 20);
		$max = mt_rand(30, 40);

		$this->assertSame([

			AbstractRangeValidator::PARAM_MIN => $min,
			AbstractRangeValidator::PARAM_MAX => $max,

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
			->getMockBuilder(AbstractRangeValidator::class)
			->getMockForAbstractClass();

		/* @var $validator AbstractRangeValidator */

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

			[ [ AbstractRangeValidator::PARAM_MAX => 10 ], 'MIN' ],
			[ [ AbstractRangeValidator::PARAM_MIN => 10 ], 'MAX' ],

		];
	}

	public function test_message_args()
	{
		$validator = $this
			->getMockBuilder(AbstractRangeValidator::class)
			->getMockForAbstractClass();

		/* @var $validator AbstractRangeValidator */

		$context = new Context;
		$min = mt_rand(10, 20);
		$max = mt_rand(30, 40);
		$context->validator_params = [

			AbstractRangeValidator::PARAM_MIN => $min,
			AbstractRangeValidator::PARAM_MAX => $max,

		];

		$validator->validate(mt_rand(50, 60), $context);

		$this->assertArrayHasKey(AbstractRangeValidator::MESSAGE_ARG_MIN, $context->message_args);
		$this->assertArrayHasKey(AbstractRangeValidator::MESSAGE_ARG_MAX, $context->message_args);
		$this->assertArrayHasKey(AbstractRangeValidator::MESSAGE_ARG_VALUE_TYPE, $context->message_args);
		$this->assertSame($min, $context->message_args[AbstractRangeValidator::MESSAGE_ARG_MIN]);
		$this->assertSame($max, $context->message_args[AbstractRangeValidator::MESSAGE_ARG_MAX]);
		$this->assertSame('integer', $context->message_args[AbstractRangeValidator::MESSAGE_ARG_VALUE_TYPE]);
	}
}
