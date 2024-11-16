<?php

namespace ICanBoogie\Validate;

use ICanBoogie\Validate\Reader\ArrayAdapter;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
class ContextTest extends TestCase
{
    private Context $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new Context();
    }

    public function test_value(): void
    {
        $name = uniqid();
        $value = uniqid();
        $this->sut->reader = new ArrayAdapter([ $name => $value ]);

        $this->assertSame($value, $this->sut->value($name));
    }

    public function test_param(): void
    {
        $name = uniqid();
        $value = uniqid();
        $this->sut->validator_params = [ $name => $value ];

        $this->assertSame($value, $this->sut->param($name));
    }

    public function test_param_undefined(): void
    {
        $this->expectException(ParameterIsMissing::class);
        $this->sut->param(uniqid());
    }

    public function test_option(): void
    {
        $name = uniqid();
        $value = uniqid();
        $this->sut->validator_params = [ $name => $value ];

        $this->assertSame($value, $this->sut->option($name));
    }

    public function test_option_undefined(): void
    {
        $this->assertNull($this->sut->option(uniqid()));
    }

    public function test_option_undefined_with_default(): void
    {
        $default = uniqid();
        $this->assertSame($default, $this->sut->option(uniqid(), $default));
    }
}
