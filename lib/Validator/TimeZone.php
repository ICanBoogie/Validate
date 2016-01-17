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
 * Validates a time zone.
 *
 * **Note:** This class validates _time zone_ such as "Europe/Pairs" **NOT** _time zone offsets_
 * such as "+02:00".
 */
class TimeZone extends AbstractValidator
{
	const ALIAS = 'timezone';
	const DEFAULT_MESSAGE = "`{value}` is not a valid time zone identifier, did you mean `{suggestion}`?";

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		$identifiers = timezone_identifiers_list();

		if (in_array($value, $identifiers))
		{
			return true;
		}

		$context->message_args['suggestion'] = $this->find_best_match($value, $identifiers);

		return false;
	}

	/**
	 * Find best possible match.
	 *
	 * @param string $value
	 * @param array $identifiers
	 *
	 * @return string
	 */
	protected function find_best_match($value, array $identifiers)
	{
		$matches = array_fill_keys($identifiers, 0);

		foreach ($identifiers as $identifier)
		{
			similar_text($identifier, $value, $matches[$identifier]);
		}

		arsort($matches);

		return key($matches);
	}
}
