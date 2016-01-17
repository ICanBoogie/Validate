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

use ICanBoogie\Validate\Context;

class SampleValidator extends AbstractValidator
{
	const ALIAS = 'sample';
	const DEFAULT_MESSAGE = 'is not sample';

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		return $value === 'sample';
	}
}
