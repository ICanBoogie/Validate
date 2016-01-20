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
class MessageTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_test_format
	 *
	 * @param string $message
	 * @param mixed $value
	 * @param string $expected
	 */
	public function test_format($message, $value, $expected)
	{
		$this->assertSame($expected, (string) new Message($message, [ 'value' => $value ]));
	}

	public function provide_test_format()
	{
		return [

			[ '`{value}` is invalid', 1, '`1` is invalid' ],
			[ '`{value}` is invalid', null, '`null` is invalid' ],
			[ '`{value}` is invalid', true, '`true` is invalid' ],
			[ '`{value}` is invalid', false, '`false` is invalid' ],
			[ '`{value}` is invalid', new \stdClass(), '`instance stdClass` is invalid' ],
			[ '`{value}` is invalid', [ 'one' => 1, 'two' => 2 ], '`array{one, two}` is invalid' ],
			[ '`{value}` is invalid', fopen(__FILE__, 'r'), '`type{resource}` is invalid' ],

		];
	}
}
