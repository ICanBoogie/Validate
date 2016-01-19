<?php

namespace ICanBoogie\Validate;

class ContextTest extends \PHPUnit_Framework_TestCase
{
	public function test_param()
	{
		$param = uniqid();
		$value = uniqid();
		$context = new Context;
		$context->validator_params = [ $param => $value ];

		$this->assertSame($value, $context->param($param));
	}

	/**
	 * @expectedException \ICanBoogie\Validate\ParameterIsMissing
	 */
	public function test_param_undefined()
	{
		$context = new Context;
		$context->param(uniqid());
	}

	public function test_option()
	{
		$option = uniqid();
		$value = uniqid();
		$context = new Context;
		$context->validator_params = [ $option => $value ];

		$this->assertSame($value, $context->option($option));
	}

	public function test_option_undefined()
	{
		$context = new Context;
		$this->assertNull($context->option(uniqid()));
	}
}
