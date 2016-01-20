<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\ValueReader;

/**
 * @small
 */
abstract class ReaderTestCase extends \PHPUnit_Framework_TestCase
{
	const READER_CLASS = null;

	/**
	 * @dataProvider provide_test_read
	 *
	 * @param mixed $data
	 * @param string $field
	 * @param mixed $expected
	 */
	public function test_read($data, $field, $expected)
	{
		/* @var $reader \ICanBoogie\Validate\Reader */
		$class = static::READER_CLASS;
		$reader = new $class($data);
		$this->assertSame($expected, $reader->read($field));
	}

	abstract public function provide_test_read();
}
