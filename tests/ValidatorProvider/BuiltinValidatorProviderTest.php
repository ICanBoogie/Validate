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

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator;

/**
 * @medium
 */
class BuiltinValidatorProviderTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var BuiltinValidatorProvider
	 */
	private $provider;

	protected function setUp(): void
	{
		if (!$this->provider)
		{
			$this->provider = new BuiltinValidatorProvider;
		}
	}

	public function test_should_throw_exception_if_validator_is_not_defined(): void
	{
		$provider = $this->provider;
		$this->expectException(UndefinedValidator::class);
		$provider(uniqid());
	}

	/**
	 * @dataProvider provide_test_alias_mapping
	 *
	 * @param string $class
	 * @param string $alias
	 */
	public function test_alias_mapping($class, $alias)
	{
		$provider = $this->provider;
		$validator = $provider($class);
		$this->assertInstanceOf($class, $validator);
		$this->assertSame($validator, $provider($alias));
	}

	/**
	 * @return array
	 */
	public function provide_test_alias_mapping()
	{
		return array_map(function ($class) {

			return [ $class, $class::ALIAS ];

		}, [

			Validator\Between::class,
			Validator\BetweenLength::class,
			Validator\Blank::class,
			Validator\Boolean::class,
			Validator\Email::class,
			Validator\Equal::class,
			Validator\Identical::class,
			Validator\IsFalse::class,
			Validator\IsNull::class,
			Validator\IsTrue::class,
			Validator\JSON::class,
			Validator\Max::class,
			Validator\MaxLength::class,
			Validator\Min::class,
			Validator\MinLength::class,
			Validator\NotBetween::class,
			Validator\NotBetweenLength::class,
			Validator\NotBlank::class,
			Validator\NotEqual::class,
			Validator\NotIdentical::class,
			Validator\NotNull::class,
			Validator\Regex::class,
			Validator\Required::class,
			Validator\TimeZone::class,
			Validator\Type::class,
			Validator\URL::class,

		]);
	}
}
