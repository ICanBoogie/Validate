<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\Validator;
use ICanBoogie\Validate\Validator\SampleValidator;

/**
 * @medium
 */
class BuiltinValidatorProviderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider provide_test_builtin_validator
	 *
	 * @param string $class
	 * @param string $alias
	 */
	public function test_builtin_validator($class, $alias)
	{
		$provider = new BuiltinValidatorProvider;
		$validator = $provider($class);
		$this->assertInstanceOf($class, $validator);
		$this->assertSame($validator, $provider($alias));
	}

	public function provide_test_builtin_validator()
	{
		return [

			[ Validator\Blank::class,     Validator\Blank::ALIAS ],
			[ Validator\Email::class,     Validator\Email::ALIAS ],
			[ Validator\IsFalse::class,   Validator\IsFalse::ALIAS ],
			[ Validator\IsNull::class,    Validator\IsNull::ALIAS ],
			[ Validator\IsTrue::class,    Validator\IsTrue::ALIAS ],
			[ Validator\Max::class,       Validator\Max::ALIAS ],
			[ Validator\MaxLength::class, Validator\MaxLength::ALIAS ],
			[ Validator\Min::class,       Validator\Min::ALIAS ],
			[ Validator\MinLength::class, Validator\MinLength::ALIAS ],
			[ Validator\NotBlank::class,  Validator\NotBlank::ALIAS ],
			[ Validator\NotNull::class,   Validator\NotNull::ALIAS ],
			[ Validator\Required::class,  Validator\Required::ALIAS ],
			[ Validator\TimeZone::class,  Validator\TimeZone::ALIAS ],
			[ Validator\Type::class,      Validator\Type::ALIAS ],
			[ Validator\URL::class,       Validator\URL::ALIAS ],

		];
	}

	public function test_custom_validator()
	{
		$validator = new SampleValidator;

		$provider = new BuiltinValidatorProvider([

			SampleValidator::class => $validator

		], [

			SampleValidator::ALIAS => SampleValidator::class

		]);

		$this->assertSame($validator, $provider(SampleValidator::ALIAS));
		$this->assertSame($validator, $provider(SampleValidator::class));
	}
}
