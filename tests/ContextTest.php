<?php

namespace ICanBoogie\Validate;

use ICanBoogie\Validate\Reader\ArrayAdapter;

/**
 * @small
 */
class ContextTest extends \PHPUnit\Framework\TestCase
{
	public function test_value()
	{
		$name = uniqid();
		$value = uniqid();
		$context = new Context;
		$context->reader = new ArrayAdapter([ $name => $value ]);

		$this->assertSame($value, $context->value($name));
	}

	public function test_param()
	{
		$name = uniqid();
		$value = uniqid();
		$context = new Context;
		$context->validator_params = [ $name => $value ];

		$this->assertSame($value, $context->param($name));
	}

	public function test_param_undefined(): void
	{
		$context = new Context;
		$this->expectException(ParameterIsMissing::class);
		$context->param(uniqid());
	}

	public function test_option(): void
	{
		$name = uniqid();
		$value = uniqid();
		$context = new Context;
		$context->validator_params = [ $name => $value ];

		$this->assertSame($value, $context->option($name));
	}

	public function test_option_undefined()
	{
		$context = new Context;
		$this->assertNull($context->option(uniqid()));
	}

	public function test_option_undefined_with_default()
	{
		$default = uniqid();
		$context = new Context;
		$this->assertSame($default, $context->option(uniqid(), $default));
	}
}
