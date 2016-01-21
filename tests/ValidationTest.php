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

use ICanBoogie\Validate\Validator\Email;
use ICanBoogie\Validate\Validator\Required;
use ICanBoogie\Validate\Reader\ArrayAdapter;

/**
 * @large
 */
class ValidationTest extends \PHPUnit_Framework_TestCase
{
	public function test_custom_message()
	{
		$validation = new Validation([

			'email' => [

				Email::class => [

					Email::OPTION_MESSAGE => "{value} is not a valid email address."

				]

			]

		]);

		$errors = $validation->validate(new ArrayAdapter([

			'email' => 'person'

		]));

		$this->assertEquals([

			'email' => [ "person is not a valid email address." ]

		], $this->stringify_errors($errors));
	}

	public function test_if()
	{
		$email = uniqid();

		$validation = new Validation([

			'email' => [

				Email::class => [

					Email::OPTION_IF => function(Context $context) use ($email) {

						$this->assertEquals('email', $context->attribute);
						$this->assertEquals($email, $context->value);

						return true;

					}

				]

			]

		]);

		$errors = $validation->validate(new ArrayAdapter([

			'email' => $email

		]));

		$this->assertArrayHasKey('email', $errors);
	}

	public function test_not_if()
	{
		$validation = new Validation([

			'email' => [

				Email::class => [

					Email::OPTION_IF => function() { return false; }

				]

			]

		]);

		$errors = $validation->validate(new ArrayAdapter([

			'email' => 'person'

		]));

		$this->assertArrayNotHasKey('email', $errors);
	}

	public function test_unless()
	{
		$email = uniqid();

		$validation = new Validation([

			'email' => [

				Email::class => [

					Email::OPTION_UNLESS => function(Context $context) use ($email) {

						$this->assertEquals('email', $context->attribute);
						$this->assertEquals($email, $context->value);

						return false;

					}

				]

			]

		]);

		$errors = $validation->validate(new ArrayAdapter([

			'email' => $email

		]));

		$this->assertArrayHasKey('email', $errors);
	}

	public function test_not_unless()
	{
		$validation = new Validation([

			'email' => [

				Email::class => [

					Email::OPTION_UNLESS => function() { return true; }

				]

			]

		]);

		$errors = $validation->validate(new ArrayAdapter([

			'email' => 'person'

		]));

		$this->assertArrayNotHasKey('email', $errors);
	}

	public function test_required()
	{
		$validation = new Validation([

			'email' => [

				Required::class => [

					Required::OPTION_STOP_ON_ERROR => true

				],

				Email::class => []

			]

		]);

		$errors = $validation->validate(new ArrayAdapter([]));

		$this->assertEquals([

			'email' => [ Required::DEFAULT_MESSAGE ]

		], $this->stringify_errors($errors));
	}

	/**
	 * @dataProvider provide_test_message
	 *
	 * @param string $validator_name
	 * @param array $params
	 * @param mixed $value
	 * @param string $expected
	 */
	public function test_message($validator_name, $params, $value, $expected)
	{
		$attribute = uniqid();
		$validation = new Validation([ $attribute => [ $validator_name => $params ]]);
		$errors = $validation->validate(new ArrayAdapter([ $attribute => $value ]));
		$this->assertArrayHasKey($attribute, $errors);
		$this->assertSame($expected, (string) reset($errors[$attribute]));
	}

	public function provide_test_message()
	{
		return [

			[ Validator\Blank::class,     [], uniqid(), Validator\Blank::DEFAULT_MESSAGE ],
			[ Validator\Email::class,     [], 'person', "`person` is not a valid email address" ],
			[ Validator\Equal::class,     [ 3 ], 4, "should equal 3" ],
			[ Validator\IsFalse::class,   [], true, Validator\IsFalse::DEFAULT_MESSAGE ],
			[ Validator\IsNull::class,    [], uniqid(), Validator\IsNull::DEFAULT_MESSAGE ],
			[ Validator\IsTrue::class,    [], false, Validator\IsTrue::DEFAULT_MESSAGE ],
			[ Validator\Max::class,       [ 10 ], 12, "should be at most 10" ],
			[ Validator\MaxLength::class, [ 3 ], "abcd", "should be at most 3 characters long" ],
			[ Validator\Min::class,       [ 10 ], 8, "should be at least 10" ],
			[ Validator\MinLength::class, [ 3 ], "ab", "should be at least 3 characters long" ],
			[ Validator\NotBlank::class,  [], '', Validator\NotBlank::DEFAULT_MESSAGE ],
			[ Validator\NotEqual::class,  [ 3 ], 3, "should not equal 3" ],
			[ Validator\NotNull::class,   [], null, Validator\NotNull::DEFAULT_MESSAGE ],
			[ Validator\Required::class,  [], null, Validator\Required::DEFAULT_MESSAGE ],
			[ Validator\TimeZone::class,  [], 'Europe/Pas', "`Europe/Pas` is not a valid time zone, did you mean `Europe/Paris`?" ],
			[ Validator\Type::class,      [ 'integer' ], null, "should be of type integer" ],
			[ Validator\URL::class,       [], 'icanboogie.org', "`icanboogie.org` is not a valid URL" ],

		];
	}

	public function test_encoded_validators()
	{
		$validation = new Validation([

			'name' => 'required|min-length:3',
			'email' => 'required|email!|max-length:3',
			'password' => 'required|min-length:6',
			'consent' => 'required'

		]);

		$errors = $validation->validate(new ArrayAdapter([

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

	public function test_assert_no_error()
	{
		$validation = new Validation([

			'email' => 'required|email'

		]);

		$validation->assert(new ArrayAdapter([ 'email' => 'person@domain.tld' ]));
	}

	/**
	 * @expectedException \ICanBoogie\Validate\ValidationFailed
	 */
	public function test_assert()
	{
		$validation = new Validation([

			'email' => 'required|email'

		]);

		$validation->assert(new ArrayAdapter([]));
	}

	/**
	 * @param ValidationErrors|array $errors
	 *
	 * @return ValidationErrors|array
	 */
	private function stringify_errors($errors)
	{
		if (!$errors)
		{
			return [];
		}

		#
		# HHVM's array_walk_recursive() doesn't work with ArrayObject :(
		#

		$errors = $errors->to_array();

		array_walk_recursive($errors, function(Message &$message) {

			$message = (string) $message;

		});

		return $errors;
	}
}
