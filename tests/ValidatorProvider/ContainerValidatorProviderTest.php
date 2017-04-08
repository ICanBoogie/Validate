<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator\Required;
use Psr\Container\ContainerInterface;

class ContainerValidatorProviderTest extends \PHPUnit_Framework_TestCase
{
	public function test_should_throw_exception_if_service_not_defined()
	{
		$prefix = uniqid();
		$alias = uniqid();
		$container = $this->getMockBuilder(ContainerInterface::class)
			->setMethods([ 'has' ])
			->getMockForAbstractClass();
		$container
			->expects($this->once())
			->method('has')
			->with($prefix . $alias)
			->willReturn(false);

		/* @var $container ContainerInterface */

		$provider = new ContainerValidatorProvider($container, $prefix);

		try
		{
			$provider($alias);
		}
		catch (UndefinedValidator $e)
		{
			$this->assertSame($alias, $e->class_or_alias);
			return;
		}

		$this->fail("Expected UndefinedValidator");
	}

	public function test_should_provide_validator_using_class()
	{
		$prefix = uniqid();
		$alias = Required::ALIAS;
		$validator = new Required;
		$container = $this->getMockBuilder(ContainerInterface::class)
			->setMethods([ 'has', 'get' ])
			->getMockForAbstractClass();
		$container
			->expects($this->once())
			->method('has')
			->with($prefix . $alias)
			->willReturn(true);
		$container
			->expects($this->once())
			->method('get')
			->with($prefix . $alias)
			->willReturn($validator);

		/* @var $container ContainerInterface */

		$provider = new ContainerValidatorProvider($container, $prefix);
		$this->assertSame($validator, $provider(Required::class));
	}

	public function test_should_provide_validator_using_alias()
	{
		$prefix = uniqid();
		$alias = Required::ALIAS;
		$validator = new Required;
		$container = $this->getMockBuilder(ContainerInterface::class)
			->setMethods([ 'has', 'get' ])
			->getMockForAbstractClass();
		$container
			->expects($this->once())
			->method('has')
			->with($prefix . $alias)
			->willReturn(true);
		$container
			->expects($this->once())
			->method('get')
			->with($prefix . $alias)
			->willReturn($validator);

		/* @var $container ContainerInterface */

		$provider = new ContainerValidatorProvider($container, $prefix);
		$this->assertSame($validator, $provider($alias));
	}
}
