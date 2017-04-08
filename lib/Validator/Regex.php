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
 * Validates that a value matches a regular expression.
 */
class Regex extends ValidatorAbstract
{
	const ALIAS = 'regex';
	const DEFAULT_MESSAGE = "`{value}` does not match pattern";

	const PARAM_PATTERN = 'pattern';
	const OPTION_NOT_MATCH = 'not_match';

	const MESSAGE_ARG_PATTERN = 'pattern';

	const NOT_MATCH = true;
	const MATCH = false;

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		$pattern = $context->param(self::PARAM_PATTERN);
		$not_match = $context->option(self::OPTION_NOT_MATCH);

		$context->message_args[self::MESSAGE_ARG_PATTERN] = $pattern;

		$result = preg_match($pattern, $value);

		return $not_match ? $result !== 1 : $result === 1;
	}

	/**
	 * @inheritdoc
	 */
	protected function get_params_mapping()
	{
		return [ self::PARAM_PATTERN, self::OPTION_NOT_MATCH ];
	}
}
