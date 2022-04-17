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
 * @small
 */
class TimeZoneTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = TimeZone::class;

	public function provide_test_valid_values()
	{
		return [
			[ 'Europe/Paris' ],
			[ 'Asia/Tokyo' ],
		];
	}

	public function provide_test_invalid_values(): array
    {
		return [
			[ 'Paris' ],
			[ 'Tokyo' ],
			[ '+02:00' ],
		];
	}

	public function test_suggestion()
	{
		$validator = new TimeZone;
		$context = new Context;
		$this->assertFalse($validator->validate('Europe/Pas', $context));
		$this->assertArrayHasKey('suggestion', $context->message_args);
		$this->assertEquals('Europe/Paris', $context->message_args['suggestion']);
	}
}
