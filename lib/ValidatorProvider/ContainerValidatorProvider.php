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
use Psr\Container\ContainerInterface;

class ContainerValidatorProvider implements ValidatorProvider
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @var string
	 */
	private $prefix;

	/**
	 * @param ContainerInterface $container
	 * @param string $prefix
	 */
	public function __construct(ContainerInterface $container, $prefix = '')
	{
		$this->container = $container;
		$this->prefix = $prefix;
	}

	/**
	 * @inheritdoc
	 */
	public function __invoke($class_or_alias)
	{
		$alias = $this->resolve_alias($class_or_alias);
		$id = $this->prefix . $alias;

		if (!$this->container->has($id))
		{
			throw new UndefinedValidator($class_or_alias);
		}

		return $this->container->get($id);
	}

	/**
	 * @param string $class_or_alias
	 *
	 * @return string
	 */
	private function resolve_alias($class_or_alias)
	{
		if (class_exists($class_or_alias))
		{
			/* @var $class_or_alias \ICanBoogie\Validate\Validator */

			return $class_or_alias::ALIAS;
		}

		return $class_or_alias;
	}
}
