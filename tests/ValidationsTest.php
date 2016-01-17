<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate;

use ICanBoogie\Validate\Message;
use ICanBoogie\Validate\Validator\Email;
use ICanBoogie\Validate\Validator\IsFalse;
use ICanBoogie\Validate\Validator\IsTrue;
use ICanBoogie\Validate\Validator\Required;
use ICanBoogie\Validate\ValueReader\ArrayValueReader;

class ValidationsTest extends \PHPUnit_Framework_TestCase
{
	public function test_invalid()
	{
		$validations = new Validations([

			'true' => [

				IsTrue::class => []

			],

			'yes' => [

				'is-true' => []

			],

			'false' => [

				IsFalse::class => []

			],

			'no' => [

				'is-false' => []

			],

			'email' => [

				Required::class => [],
				Email::class => [

					Email::OPTION_MESSAGE => "`{value}` is not a valid email address."

				]
			]

		]);

		$errors = $validations->validate(new ArrayValueReader([

			'true' => false,
			'yes' => 'no',
			'false' => true,
			'no' => 'yes',
			'email' => 'person@domain'

		]));

		$this->assertEquals([

			'true' => [ "should be true" ],
			'yes' => [ "should be true" ],
			'false' => [ "should be false" ],
			'no' => [ "should be false" ],
			'email' => [ "`person@domain` is not a valid email address." ]

		], $errors);
	}

	public function test_custom_message()
	{
		$validations = new Validations([

			'email' => [

				Email::class => [

					Email::OPTION_MESSAGE => "{value} is not a valid email address."

				]

			]

		]);

		$errors = $validations->validate(new ArrayValueReader([

			'email' => 'person'

		]));

		$this->assertEquals([

			'email' => [ "person is not a valid email address." ]

		], $errors);
	}

	public function test_if()
	{
		$validations = new Validations([

			'email' => [

				Email::class => [

					Email::OPTION_IF => function() { return true; }

				]

			]

		]);

		$errors = $validations->validate(new ArrayValueReader([

			'email' => 'person'

		]));

		$this->assertArrayHasKey('email', $errors);
	}

	public function test_not_if()
	{
		$validations = new Validations([

			'email' => [

				Email::class => [

					Email::OPTION_IF => function() { return false; }

				]

			]

		]);

		$errors = $validations->validate(new ArrayValueReader([

			'email' => 'person'

		]));

		$this->assertArrayNotHasKey('email', $errors);
	}

	public function test_unless()
	{
		$validations = new Validations([

			'email' => [

				Email::class => [

					Email::OPTION_UNLESS => function() { return false; }

				]

			]

		]);

		$errors = $validations->validate(new ArrayValueReader([

			'email' => 'person'

		]));

		$this->assertArrayHasKey('email', $errors);
	}

	public function test_not_unless()
	{
		$validations = new Validations([

			'email' => [

				Email::class => [

					Email::OPTION_UNLESS => function() { return true; }

				]

			]

		]);

		$errors = $validations->validate(new ArrayValueReader([

			'email' => 'person'

		]));

		$this->assertArrayNotHasKey('email', $errors);
	}

	public function test_required()
	{
		$validations = new Validations([

			'email' => [

				Required::class => [

					Required::OPTION_STOP_ON_ERROR => true

				],

				Email::class => []

			]

		]);

		$errors = $validations->validate(new ArrayValueReader([]));

		$this->assertEquals([

			'email' => [ Required::DEFAULT_MESSAGE ]

		], $errors);
	}

	/**
	 * @dataProvider provide_test_message
	 *
	 * @param string $validator_name
	 * @param array $options
	 * @param mixed $value
	 * @param string $expected
	 */
	public function test_message($validator_name, $options, $value, $expected)
	{
		$validations = new Validations([ 'field' => [ $validator_name => $options ]]);
		$errors = $validations->validate(new ArrayValueReader([ 'field' => $value ]));
		$this->assertArrayHasKey('field', $errors);
		$this->assertSame($expected, (string) reset($errors['field']));
	}

	public function provide_test_message()
	{
		return [

			[ Validator\Blank::class,     [], uniqid(), Validator\Blank::DEFAULT_MESSAGE ],
			[ Validator\Email::class,     [], 'person', "`person` is not a valid email address" ],
			[ Validator\IsFalse::class,   [], true, Validator\IsFalse::DEFAULT_MESSAGE ],
			[ Validator\IsNull::class,    [], uniqid(), Validator\IsNull::DEFAULT_MESSAGE ],
			[ Validator\IsTrue::class,    [], false, Validator\IsTrue::DEFAULT_MESSAGE ],
			[ Validator\Min::class,       [ 10 ], 8, "should be at least 10" ],
			[ Validator\MinLength::class, [ 3 ], "ab", "should be at least 3 characters long" ],
			[ Validator\Max::class,       [ 10 ], 12, "should be at most 10" ],
			[ Validator\MaxLength::class, [ 3 ], "abcd", "should be at most 3 characters long" ],
			[ Validator\NotBlank::class,  [], '', Validator\NotBlank::DEFAULT_MESSAGE ],
			[ Validator\NotNull::class,   [], null, Validator\NotNull::DEFAULT_MESSAGE ],
			[ Validator\Required::class,  [], null, Validator\Required::DEFAULT_MESSAGE ],
			[ Validator\Type::class,      [ 'integer' ], null, "should be of type integer" ],

		];
	}

	public function test_encoded_validators()
	{
		$validations = new Validations([

			'name' => 'required|min-length:3',
			'email' => 'required|email',
			'password' => 'required|min-length:6',
			'consent' => 'required'

		]);

		$errors = $validations->validate(new ArrayValueReader([

			'name' => "Ol",
			'email' => "olivier",
			'password' => "123"

		]));

		$this->assertSame([

			'name' => [ "should be at least 3 characters long" ],
			'email' => [ "`olivier` is not a valid email address" ],
			'password' => [ "should be at least 6 characters long" ],
			'consent' => [ "is required" ]

		], $this->stringify_errors($errors));
	}

	private function stringify_errors(array $errors)
	{
		array_walk_recursive($errors, function(Message &$message) {

			$message = (string) $message;

		});

		return $errors;
	}
}
