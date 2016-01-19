# Validate

[![Release](https://img.shields.io/packagist/v/icanboogie/validate.svg)](https://packagist.org/packages/icanboogie/validate)
[![Build Status](https://img.shields.io/travis/ICanBoogie/Validate/master.svg)](http://travis-ci.org/ICanBoogie/Validate)
[![HHVM](https://img.shields.io/hhvm/icanboogie/validate.svg)](http://hhvm.h4cc.de/package/icanboogie/validate)
[![Code Quality](https://img.shields.io/scrutinizer/g/icanboogie/validate.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Validate)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Validate.svg)](https://coveralls.io/r/ICanBoogie/Validate)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/validate.svg)](https://packagist.org/packages/icanboogie/validate)

The **icanboogie/validate** offers a simple API to validate data.

The following validators are available:

- [Blank][], `blank`: Validates that a value is blank.
- [Email][], `email`: Validates that a value is a valid email.
- [IsFalse][], `is-false`: Validates that a value is false.
- [IsNull][], `is-null`: Validates that a value is `null`.
- [IsTrue][], `is-true`: Validates that a value is true.
- [Max][], `max`: Validates that a value has a maximum value.
- [MaxLength][], `max-length`: Validates that a value has a maximum length.
- [Min][], `min`: Validates that a value has a minimum value.
- [MinLength][], `min-length`: Validates that a value has a minimum length.
- [NotBlank][], `not-blank`: Validates that a value is blank.
- [NotNull][], `not-null`: Validates that a value is not `null`.
- [Required][], `required`: States that a value is required.
- [TimeZone][], `timezone`: Validates that a value is a valid time zone.
- [Type][], `type`: Validates that a value is of a specified type.
- [URL][], `url`: Validates that a value is a valid URL.

```php
<?php

use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\ValueReader\ArrayValueReader;

$validation = new Validation([

	'name' => 'required|min-length:3',
	'email' => 'required|email!|unique',
	'password' => 'required|min-length:6',
	'consent' => 'required'

]);

$errors = $validation->validate(new ArrayValueReader([

	'name' => "Ol",
	'email' => "olivier",
	'password' => "123"

]));

var_dump($errors);
```

```
array(4) {
  'name' =>
  array(1) {
    [0] =>
    string(36) "should be at least 3 characters long"
  }
  'email' =>
  array(1) {
    [0] =>
    string(38) "`olivier` is not a valid email address"
  }
  'password' =>
  array(1) {
    [0] =>
    string(36) "should be at least 6 characters long"
  }
  'consent' =>
  array(1) {
    [0] =>
    string(11) "is required"
  }
}
```





## Validation

A validation is defined using an array of key/value pairs where _key_ is an attribute to validate and _key_ is the rules. Rules may be defined as a string or an array of key/value pairs where _key_ is a validator class, or alias, and _value_ an array of parameters and options. Optionally you may provide a validator provider and a message formatter.

A validation is represented by a [Validation][] instance.

```php
<?php

use ICanBoogie\Validate\Validation;

$validation = new Validation([

	'name' => 'required|min-length:3',

]);

# or

$validation = new Validation([

	'name' => [
	
		'required' => [],
		'min-length' => [ 3 ],
	]
	
]);

# or

use ICanBoogie\Validate\Validator;

$validation = new Validation([

	'name' => [
	
		Validator\Required::class => [],
		Validator\MinLength::class => [ 3 ],
	]
	
]);

# or

use ICanBoogie\Validate\Validator;

$validation = new Validation([

	'name' => [
	
		Validator\Required::class => [],
		Validator\MinLength::class => [ Validator\MinLength::PARAM_REFERENCE => 3 ],
	]

]);
```

Use the `validate()` method and an appropriate value reader from the source of data. The method returns a [ValidationErrors][] instance if the validation failed, an empty array otherwise.

```php
<?php

$errors = $validation->validate(new ArrayValueReader($_POST));

if (!$errors)
{
	// because `$errors` is an empty array we can check if it is empty with `!`.
}

foreach ($errors as $attribute => $messages)
{
	// …
}
```





## Special validation options

The following validation options may be defined:

- `ValidatorOptions::OPTION_MESSAGE`: A custom error message, which overrides the validator default message.

- `ValidatorOptions::OPTION_IF`: The validator is used only if the callable defined by this option returns `true`. The callable may be a closure or an instance implementing the [IfCallable][] interface.

- `ValidatorOptions::OPTION_UNLESS`: The validator is skipped if the callable defined by this option returns `true`. The callable may be a closure or an instance implementing the [UnlessCallable][] interface.

- `ValidatorOptions::OPTION_STOP_ON_ERROR`: If `true`, the validation of a value stops after an error. This option is always `true` for the [Required][] validator.

```php
<?php

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\Validator\Required;
use ICanBoogie\Validate\Validator\Email;

$validation = new Validation([

	'email' => [
	
		Required::class => [
	
			Required::OPTION_MESSAGE => "An email address must be supplied if your wish to register.",

			Required::OPTION_IF => function(Context $context) {
			
				return $context->values->read('name')
			
			},
			
			Required::OPTION_UNLESS => function(Context $context) {
			
				return !$context->values->read('register')
			
			},
			
			Required::OPTION_STOP_ON_ERROR => true // already defined by Require
		
		],
		
		Email::class => [
	
			Email::OPTION_MESSAGE => "`{value}` is an invalid email address for the field E-Mail.",

		]
	
	]

]);
```





## Validation context

The validation context provides the following information:

- `attribute`: The attribute being validated.
- `value`: The value of the attribute being validated.
- `validator`: The current validator.
- `validator_params`: The parameters and options for the current validator.
- `values`: The adapter giving access to the values being validated.
- `message`: The possible error message for the current validator.
- `message_args`: The arguments for the possible error message.
- `errors`: The collected errors.

The validation context is represented by a [Context][] instance and is passed along with the value to validate to the validator. The validator may used the context to retrieve parameters and options, and when required get a complete picture of the ongoing validation.

The following example demonstrates how a validator may retrieve its parameters and options from the context, and a value from the value reader:

```php
<?php

use ICanBoogie\Validate\Context

// …

	const PARAM_REFERENCE = 'reference';
	const OPTION_STRICT = 'strict;

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		$reference = $context->param(self::PARAM_REFERENCE);
		$strict = $context->option(self::OPTION_STRICT, false);
		$other_value = $context->value('some_other_value');
	}

// …

```





----------





## Requirements

The package requires PHP 5.5 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/):

```
$ composer require icanboogie/validate
```





### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/validate), its repository can be
cloned with the following command line:

	$ git clone https://github.com/ICanBoogie/validate.git





## Documentation

The package is documented as part of the [ICanBoogie][] framework
[documentation][]. You can generate the documentation for the package and its dependencies with
the `make doc` command. The documentation is generated in the `build/docs` directory.
[ApiGen](http://apigen.org/) is required. The directory can later be cleaned with the
`make clean` command.





## Testing

The test suite is ran with the `make test` command. [PHPUnit](https://phpunit.de/) and
[Composer](http://getcomposer.org/) need to be globally available to run the suite. The command
installs dependencies as required. The `make test-coverage` command runs test suite and also
creates an HTML coverage report in `build/coverage`. The directory can later be cleaned with
the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/ICanBoogie/Validate/master.svg)](https://travis-ci.org/ICanBoogie/Validate)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Validate.svg)](https://coveralls.io/r/ICanBoogie/Validate)





## License

**icanboogie/validate** is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[documentation]:                http://api.icanboogie.org/validate/latest/
[Context]:                      http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Context.html
[Validation]:                   http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validation.html
[ValidationErrors]:             http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.ValidationErrors.html
[IfCallable]:                   http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validation.IfCallable.html
[UnlessCallable]:               http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validation.UnlessCallable.html
[Blank]:                        http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Blank.html
[Email]:                        http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Email.html
[IsFalse]:                      http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.IsFalse.html
[IsNull]:                       http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.IsNull.html
[IsTrue]:                       http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.IsTrue.html
[Max]:                          http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Max.html
[MaxLength]:                    http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.MaxLength.html
[Min]:                          http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Min.html
[MinLength]:                    http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.MinLength.html
[NotBlank]:                     http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.NotBlank.html
[NotNull]:                      http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.NotNull.html
[Required]:                     http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Required.html
[TimeZone]:                     http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.TimeZone.html
[Type]:                         http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Type.html
[URL]:                          http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.URL.html
