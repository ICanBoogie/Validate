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
class AbstractComparisonValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function test_should_throw_exception_on_missing_reference()
	{
		$validator = $this
			->getMockBuilder(AbstractComparisonValidator::class)
			->getMockForAbstractClass();

		/* @var $validator AbstractComparisonValidator */

		try
		{
			$validator->validate(uniqid(), new Context);
		}
		catch (ParameterIsMissing $e)
		{
			$this->assertStringEndsWith('::PARAM_REFERENCE', $e->parameter);

			return;
		}

		$this->fail("Expected ParameterIsMissing");
	}

	public function test_should_add_message_arg_reference()
	{
		$validator = $this
			->getMockBuilder(AbstractComparisonValidator::class)
			->getMockForAbstractClass();

		/* @var $validator AbstractComparisonValidator */

		$context = new Context;
		$reference = uniqid();
		$context->validator_params = [ AbstractComparisonValidator::PARAM_REFERENCE => $reference ];
		$validator->validate(uniqid(), $context);

		$this->assertArrayHasKey(AbstractComparisonValidator::MESSAGE_ARG_REFERENCE, $context->message_args);
		$this->assertSame($reference, $context->message_args[AbstractComparisonValidator::MESSAGE_ARG_REFERENCE]);
	}

	public function test_should_add_message_arg_value_type()
	{
		$validator = $this
			->getMockBuilder(AbstractComparisonValidator::class)
			->getMockForAbstractClass();

		/* @var $validator AbstractComparisonValidator */

		$context = new Context;
		$reference = new \stdClass();
		$context->validator_params = [ AbstractComparisonValidator::PARAM_REFERENCE => $reference ];
		$validator->validate(uniqid(), $context);

		$this->assertArrayHasKey(AbstractComparisonValidator::MESSAGE_ARG_VALUE_TYPE, $context->message_args);
		$this->assertSame(gettype($reference), $context->message_args[AbstractComparisonValidator::MESSAGE_ARG_VALUE_TYPE]);
	}
}
