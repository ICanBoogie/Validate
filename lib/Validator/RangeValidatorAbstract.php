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
use ICanBoogie\Validate\Render;

/**
 * Abstract for classes implementing rane comparison.
 */
abstract class RangeValidatorAbstract extends ValidatorAbstract
{
	const PARAM_MIN = 'min';
	const PARAM_MAX = 'max';

	const MESSAGE_ARG_MIN = self::PARAM_MIN;
	const MESSAGE_ARG_MAX = self::PARAM_MAX;
	const MESSAGE_ARG_VALUE_TYPE = 'value_type';

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		$min = $context->param(self::PARAM_MIN);
		$max = $context->param(self::PARAM_MAX);

		$context->message_args[self::MESSAGE_ARG_MIN] = $min;
		$context->message_args[self::MESSAGE_ARG_MAX] = $max;
		$context->message_args[self::MESSAGE_ARG_VALUE_TYPE] = Render::render_type($min);

		return $this->compare($value, $min, $max);
	}

	/**
	 * @inheritdoc
	 */
	protected function get_params_mapping()
	{
		return [ self::PARAM_MIN, self::PARAM_MAX ];
	}

	/**
	 * Compares a value to a reference.
	 *
	 * @param mixed $value
	 * @param mixed $min
	 * @param mixed $max
	 *
	 * @return bool
	 */
	abstract protected function compare($value, $min, $max);
}
