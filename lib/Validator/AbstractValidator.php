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
use ICanBoogie\Validate\Validator;

/**
 * Abstract validator.
 */
abstract class AbstractValidator implements Validator
{
	/**
	 * @inheritdoc
	 */
	public function normalize_params(array $params)
	{
		foreach ($this->get_params_mapping() as $index => $param)
		{
			if (isset($params[$index]))
			{
				$params[$param] = $params[$index];

				unset($params[$index]);
			}
		}

		return $params;
	}

	/**
	 * @inheritdoc
	 */
	abstract public function validate($value, Context $context);

	/**
	 * Returns indexed parameters mapping.
	 *
	 * @return array
	 */
	protected function get_params_mapping()
	{
		return [];
	}
}
