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
 * Abstract for classes implementing value comparison.
 */
abstract class AbstractComparisonValidator extends AbstractValidator
{
	const PARAM_REFERENCE = 'reference';

	const MESSAGE_ARG_REFERENCE = self::PARAM_REFERENCE;
	const MESSAGE_ARG_VALUE_TYPE = 'value_type';

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		$reference = $context->param(self::PARAM_REFERENCE);

		$context->message_args[self::MESSAGE_ARG_REFERENCE] = $reference;
		$context->message_args[self::MESSAGE_ARG_VALUE_TYPE] = Render::render_type($reference);

		return $this->compare($value, $reference);
	}

	/**
	 * @inheritdoc
	 */
	protected function get_params_mapping()
	{
		return [ self::PARAM_REFERENCE ];
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
