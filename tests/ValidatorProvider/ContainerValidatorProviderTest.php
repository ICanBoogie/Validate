<?php

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator\Required;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ContainerValidatorProviderTest extends TestCase
{
    private MockObject&ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = $this->createMock(ContainerInterface::class);
    }

    public function test_should_throw_exception_if_service_not_defined(): void
    {
        $prefix = uniqid();
        $alias = uniqid();
        $this->container
            ->expects($this->once())
            ->method('has')
            ->with($prefix . $alias)
            ->willReturn(false);

        $provider = new ContainerValidatorProvider($this->container, $prefix);

        try {
            $provider($alias);
        } catch (UndefinedValidator $e) {
            $this->assertSame($alias, $e->class_or_alias);
            return;
        }

        $this->fail("Expected UndefinedValidator");
    }

    public function test_should_provide_validator_using_class(): void
    {
        $prefix = uniqid();
        $alias = Required::ALIAS;
        $validator = new Required();
        $this->container
            ->expects($this->once())
            ->method('has')
            ->with($prefix . $alias)
            ->willReturn(true);
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with($prefix . $alias)
            ->willReturn($validator);

        $provider = new ContainerValidatorProvider($this->container, $prefix);
        $this->assertSame($validator, $provider(Required::class));
    }

    public function test_should_provide_validator_using_alias(): void
    {
        $prefix = uniqid();
        $alias = Required::ALIAS;
        $validator = new Required();
        $this->container
            ->expects($this->once())
            ->method('has')
            ->with($prefix . $alias)
            ->willReturn(true);
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with($prefix . $alias)
            ->willReturn($validator);

        $provider = new ContainerValidatorProvider($this->container, $prefix);
        $this->assertSame($validator, $provider($alias));
    }
}
