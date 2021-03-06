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
use ICanBoogie\Validate\ValidatorProvider;

/**
 * A collection of validator providers.
 */
class ValidatorProviderCollection implements ValidatorProvider, \IteratorAggregate
{
	/**
	 * @var ValidatorProvider[]
	 */
	private $providers;

	/**
	 * @param ValidatorProvider[] $providers
	 */
	public function __construct(array $providers = [])
	{
		$this->providers = $providers;
	}

	/**
	 * @inheritdoc
	 */
	public function __invoke($class_or_alias)
	{
		foreach ($this->providers as $provider)
		{
			try
			{
				return $provider($class_or_alias);
			}
			catch (UndefinedValidator $e)
			{
				// Continue with the next provider
			}
		}

		throw new UndefinedValidator($class_or_alias);
	}

	/**
	 * @return ValidatorProvider[]|\Iterator
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->providers);
	}

	/**
	 * @param callable $provider
	 *
	 * @return $this
	 */
	public function add(callable $provider)
	{
		array_unshift($this->providers, $provider);

		return $this;
	}
}
