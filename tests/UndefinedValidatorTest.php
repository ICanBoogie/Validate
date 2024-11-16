<?php

namespace ICanBoogie\Validate;

use Exception;
use PHPUnit\Framework\TestCase;

class UndefinedValidatorTest extends TestCase
{
    public function test_exception(): void
    {
        $class_or_alias = uniqid();
        $previous = new Exception();
        $exception = new UndefinedValidator($class_or_alias, $previous);

        $this->assertSame($class_or_alias, $exception->class_or_alias);
        $this->assertSame($previous, $exception->getPrevious());
    }
}
