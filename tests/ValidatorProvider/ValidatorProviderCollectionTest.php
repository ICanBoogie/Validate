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
use ICanBoogie\Validate\Validator\SampleValidator;

class ValidatorProviderCollectionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \ICanBoogie\Validate\UndefinedValidator
	 */
	public function test_should_throw_exception_if_validator_if_not_defined()
	{
		$provider = new ValidatorProviderCollection;
		$provider(uniqid());
	}

	public function test_should_add_provider()
	{
		$provider1 = function () {};
		$provider2 = function () {};
		$provider3 = function () {};
		$provider = (new ValidatorProviderCollection)
			->add($provider1)
			->add($provider2)
			->add($provider3);

		$this->assertSame([

			$provider3,
			$provider2,
			$provider1,

		], iterator_to_array($provider));
	}

	public function test_should_return_custom_validator()
	{
		$validator = new SampleValidator;

		$failing_provider = function ($class_or_alias)
		{
			throw new UndefinedValidator($class_or_alias);
		};

		$sample_provider = function ($class_or_alias) use ($validator)
		{
			switch ($class_or_alias)
			{
				case SampleValidator::ALIAS:
				case SampleValidator::class:
					return $validator;

				default:
					throw new UndefinedValidator($class_or_alias);
			}
		};

		$provider = new ValidatorProviderCollection([

			$failing_provider,
			$sample_provider,
			new BuiltinValidatorProvider(),

		]);

		$this->assertSame($validator, $provider(SampleValidator::ALIAS));
		$this->assertSame($validator, $provider(SampleValidator::class));
	}
}
