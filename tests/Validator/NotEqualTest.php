<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Validator;

/**
 * @small
 */
class NotEqualTest extends EqualTest
{
	const VALIDATOR_CLASS = NotEqual::class;

	/**
	 * @inheritdoc
	 */
	public function provide_test_valid_values()
	{
		return parent::provide_test_invalid_values();
	}

	/**
	 * @inheritdoc
	 */
	public function provide_test_invalid_values()
	{
		return parent::provide_test_valid_values();
	}
}
