<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\MessageFormatter;

use ICanBoogie\Validate\Message;

class BuiltinMessageFormatterTest extends \PHPUnit_Framework_TestCase
{
	public function test_format()
	{
		$formatter = new BuiltinMessageFormatter;
		$pattern = "pattern {value}";
		$value = uniqid();

		$message = $formatter($pattern, [ 'value' => $value ]);
		$this->assertInstanceOf(Message::class, $message);
		$this->assertSame("pattern $value", (string) $message);
	}
}
