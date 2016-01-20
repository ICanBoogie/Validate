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

/**
 * Abstract for classes implementing value comparison.
 */
abstract class AbstractComparisonValidator extends AbstractValidator
{
	const PARAM_REFERENCE = 'reference';

	/**
	 * @inheritdoc
	 */
	public function normalize_params(array $params)
	{
		if (isset($params[0]))
		{
			$params[self::PARAM_REFERENCE] = $params[0];
		}

		return $params;
	}

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		$reference = $context->param(self::PARAM_REFERENCE);
		$context->message_args[self::PARAM_REFERENCE] = $reference;

		return $this->compare($value, $reference);
	}

	/**
	 * Compares a value to a reference.
	 *
	 * @param mixed $value
	 * @param mixed $reference
	 *
	 * @return bool
	 */
	abstract protected function compare($value, $reference);
}
