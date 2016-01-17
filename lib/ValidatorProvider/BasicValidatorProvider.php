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

use ICanBoogie\Validate\AbstractValidatorProvider;
use ICanBoogie\Validate\Validator;
use ICanBoogie\Validate\ValidatorProvider;

/**
 * Provides aliases to known validators.
 */
class BasicValidatorProvider extends AbstractValidatorProvider
{
	/**
	 * Aliases to validator classes.
	 *
	 * **Note:** The array is defined without the help of `Validator::ALIAS` so that we don't
	 * autoload a bunch of classes for nothing. Tests check that the right aliases are used.
	 *
	 * @var array
	 */
	static private $aliases = [

		'blank'      => Validator\Blank::class,
		'email'      => Validator\Email::class,
		'is-false'   => Validator\IsFalse::class,
		'is-null'    => Validator\IsNull::class,
		'is-true'    => Validator\IsTrue::class,
		'max'        => Validator\Max::class,
		'max-length' => Validator\MaxLength::class,
		'min'        => Validator\Min::class,
		'min-length' => Validator\MinLength::class,
		'not-blank'  => Validator\NotBlank::class,
		'not-null'   => Validator\NotNull::class,
		'required'   => Validator\Required::class,
		'type'       => Validator\Type::class,

	];

	/**
	 * Adds aliases to known validator classes.
	 *
	 * @inheritdoc
	 */
	public function __construct(array $instances = [], array $aliases = [])
	{
		parent::__construct($instances, $aliases + self::$aliases);
	}
}
