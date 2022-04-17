<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Reader;

use ICanBoogie\Validate\Reader;

/**
 * An abstract {@link Reader} adapter.
 */
abstract class AbstractAdapter implements Reader
{
	public function __construct(
		protected readonly mixed $source
	) {
	}
}
