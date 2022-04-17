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
class EmailTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = Email::class;

	public function provide_test_valid_values()
	{
		return [
			[ 'person@domain.com' ],
			[ 'person@domain.co.uk' ],
			[ 'person_name@domain.fr' ],
		];
	}

	public function provide_test_invalid_values(): array
    {
		return [
			[ 'person' ],
			[ 'person@' ],
			[ 'person@domain' ],
			[ 'person@domain.com bar' ],
		];
	}
}
