<?php

namespace ICanBoogie\Validate;

use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
class ValidationFailedTest extends TestCase
{
    public function test_exception(): void
    {
        $message1 = "MESSAGE" . uniqid();
        $message2 = "MESSAGE" . uniqid();
        $message3 = "MESSAGE" . uniqid();

        $errors = new ValidationErrors([

            'email' => [ $message1, $message2 ],
            'password' => [ $message3 ]

        ]);

        $exception = new ValidationFailed($errors);

        $this->assertSame($errors, $exception->errors);

        $expected = <<<EOT
Validation failed.

- email: $message1
- email: $message2
- password: $message3
EOT;

        $this->assertSame($expected, $exception->getMessage());
    }
}
