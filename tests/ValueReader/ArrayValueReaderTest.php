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

class ArrayValueReaderTestCase extends ValueReaderTestCase
{
	const READER_CLASS = ArrayValueReader::class;

	public function provide_test_read()
	{
		$p1 = uniqid();
		$v1 = uniqid();

		return [

			[ [ $p1 => $v1 ], $p1, $v1 ],
			[ [ $p1 => '0' ], $p1, '0' ],
			[ [ $p1 => false ], $p1, false ],
			[ [ $p1 => '' ], $p1, null ],
			[ [ $p1 => ' ' ], $p1, null ],
			[ [ $p1 => [] ], $p1, null ],
			[ [ ], $p1, null ],

		];
	}
}
