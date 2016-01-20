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

/**
 * A {@link Reader} adapter for an object.
 */
class ObjectAdapter extends AbstractAdapter
{
	/**
	 * If the property is not set `null` is returned.
	 *
	 * @inheritdoc
	 */
	public function read($name)
	{
		return isset($this->source->$name) ? $this->source->$name : null;
	}
}
