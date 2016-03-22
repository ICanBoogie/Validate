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
	 * @dataProvider provide_test_alias_mapping
	 *
	 * @param string $class
	 * @param string $alias
	 */
	public function test_alias_mapping($class, $alias)
	{
		$provider = new BuiltinValidatorProvider;
		$validator = $provider($class);
		$this->assertInstanceOf($class, $validator);
		$this->assertSame($validator, $provider($alias));
	}

	public function provide_test_alias_mapping()
	{
		$alias = [];

		foreach ($this->getValidators() as $class)
		{
			$alias[] = [ $class, $class::ALIAS ];
		}

		return $alias;
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

	protected function getValidators()
	{
		return [

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

		];
	}
}
