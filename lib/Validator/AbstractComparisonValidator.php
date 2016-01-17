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

/**
 * Abstract for classes implementing value comparison.
 */
abstract class AbstractComparisonValidator extends AbstractValidator
{
	const PARAM_REFERENCE = 'reference';

	/**
	 * @inheritdoc
	 *
	 * @throws ParameterIsMissing if {@link PARAM_REFERENCE} is missing.
	 */
	public function normalize_options(array $options)
	{
		if (isset($options[0]))
		{
			$options[self::PARAM_REFERENCE] = $options[0];
		}

		if (!isset($options[self::PARAM_REFERENCE]))
		{
			throw new ParameterIsMissing(get_class($this) . '::PARAM_REFERENCE');
		}

		return $options;
	}

	/**
	 * @inheritdoc
	 */
	public function validate($value, array $options, callable $error)
	{
		$reference = $options[self::PARAM_REFERENCE];

		if (!$this->compare($value, $reference))
		{
			$error(null, [

				self::PARAM_REFERENCE => $reference

			]);
		}
	}

	/**
	 * Compares two values
	 *
	 * @param mixed $value
	 * @param mixed $reference
	 *
	 * @return bool
	 */
	abstract protected function compare($value, $reference);
}