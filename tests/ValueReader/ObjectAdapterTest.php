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

use ICanBoogie\Validate\Reader\ObjectAdapter;

/**
 * @small
 */
class ObjectAdapterTest extends ReaderTestCase
{
	const READER_CLASS = ObjectAdapter::class;

	public function provide_test_read()
	{
		$p1 = 'property' . uniqid();
		$v1 = uniqid();

		return [

			[ (object) [ $p1 => $v1 ], $p1, $v1 ],
			[ (object) [ $p1 => '0' ], $p1, '0' ],
			[ (object) [ $p1 => false ], $p1, false ],
			[ (object) [ $p1 => '' ], $p1, '' ],
			[ (object) [ $p1 => ' ' ], $p1, ' ' ],
			[ (object) [ $p1 => [] ], $p1, [] ],
			[ (object) [ ], $p1, null ],

		];
	}
}
