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
 * States that a value is required. When the value is not present the validator issues an error
 * and stops validation of the value, that is on error no other validator is run.
 */
class Required extends AbstractValidator
{
	const ALIAS = 'required';
	const DEFAULT_MESSAGE = "is required";

	/**
	 * @inheritdoc
	 */
	public function normalize_params(array $params)
	{
		return array_merge([

			self::OPTION_STOP_ON_ERROR => true

		], parent::normalize_params($params));
	}

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		return $value !== null || (is_array($value) && count($value)) || (is_scalar($value) && trim($value) !== '');
	}
}
