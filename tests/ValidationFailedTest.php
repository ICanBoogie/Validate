<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate;

/**
 * @small
 */
class ValidationFailedTest extends \PHPUnit_Framework_TestCase
{
	public function test_exception()
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
