# Validate

[![Release](https://img.shields.io/packagist/v/icanboogie/validate.svg)](https://packagist.org/packages/icanboogie/validate)
[![Build Status](https://img.shields.io/travis/ICanBoogie/Validate/master.svg)](http://travis-ci.org/ICanBoogie/Validate)
[![HHVM](https://img.shields.io/hhvm/icanboogie/validate.svg)](http://hhvm.h4cc.de/package/icanboogie/validate)
[![Code Quality](https://img.shields.io/scrutinizer/g/icanboogie/validate.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Validate)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Validate.svg)](https://coveralls.io/r/ICanBoogie/Validate)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/validate.svg)](https://packagist.org/packages/icanboogie/validate)

The **icanboogie/validate** offers a simple API to validate data.

The following validators are available:

- Flags

	- [Required][], `required`: States that a value is required. Should be specified first.

- Generic

	- [Blank][], `blank`: Validates that a value is blank.
	- [NotBlank][], `not-blank`: Validates that a value is blank.

- Type comparison

	- [IsFalse][], `is-false`: Validates that a value is false.
	- [IsNull][], `is-null`: Validates that a value is `null`.
	- [NotNull][], `not-null`: Validates that a value is not `null`.
	- [IsTrue][], `is-true`: Validates that a value is true.
	- [Type][], `type`: Validates that a value is of a specified type.

- Reference comparison

	- [Equal][], `equal`: Validates that two values are equal.
	- [NotEqual][], `not-equal`: Validates that two values are not equal.
	- [Identical][], `identical`: Validates that two values are identical.
	- [NotIdentical][], `not-identical`: Validates that two values are not identical.
	- [Max][], `max`: Validates that a value has a maximum value.
	- [MaxLength][], `max-length`: Validates that a value has a maximum length.
	- [Min][], `min`: Validates that a value has a minimum value.
	- [MinLength][], `min-length`: Validates that a value has a minimum length.

- Range comparison

	- [Between][], `between`: Validates that a value is between two references.
	- [NotBetween][], `not-between`: Validates that a value is not between two references.

- Complex types

	- [Email][], `email`: Validates that a value is a valid email.
	- [JSON][], `json`: Validates that a value is a valid JSON.
	- [TimeZone][], `timezone`: Validates that a value is a valid time zone.
	- [URL][], `url`: Validates that a value is a valid URL.

```php
<?php

use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\Reader\ArrayAdapter;

$validation = new Validation([

	'name' => 'required|min-length:3',
	'email' => 'required|email!|unique',
	'password' => 'required|min-length:6',
	'consent' => 'required'

]);

$errors = $validation->validate(new ArrayAdapter([

	'name' => "Ol",
	'email' => "olivier",
	'password' => "123"

]));

var_dump($errors['name']);
var_dump((string) reset($errors['name']));
```

```
array(1) {
  [0] =>
  class ICanBoogie\Validate\Message#582 (2) {
    public $format =>
    string(46) "should be at least {reference} characters long"
    public $args =>
    array(3) {
      'value' =>
      string(2) "Ol"
      'attribute' =>
      string(4) "name"
      'reference' =>
      string(1) "3"
    }
  }
}
string(36) "should be at least 3 characters long"
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





### Validating data

The `validate()` method is used to validate data. The method returns a [ValidationErrors][] instance if the validation failed, an empty array otherwise.

```php
<?php

use ICanBoogie\Validate\Reader\RequestAdapter;

$errors = $validation->validate(new RequestAdapter($_POST));

if (!$errors)
{
	// because `$errors` is an empty array we can check if it is empty with `!`.
}

foreach ($errors as $attribute => $messages)
{
	// …
}
```





### Asserting that data is valid

The `assert()` method may be used to assert that data is valid. Instead of returning a [ValidationErrors][] instance like `validate()`, the method throws a [ValidationFailed][] exception when the validation fails. The validation errors may be retrieved from the exception.

```php
<?php

use ICanBoogie\Validate\ValidationFailed;
use ICanBoogie\Validate\Reader\RequestAdapter;

try
{
	$validation->assert(new RequestAdapter($_POST));
}
catch (ValidationFailed $e)
{
	echo get_class($e->errors); // ICanBoogie\Validate\ValidationErrors
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

				return $context->value('name')

			},

			Required::OPTION_UNLESS => function(Context $context) {

				return !$context->value('register')

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
- `reader`: A [Reader][] adapter giving access the values being validated.
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
[Reader]:                       http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Reader.html
[Validation]:                   http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validation.html
[IfCallable]:                   http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validation.IfCallable.html
[UnlessCallable]:               http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validation.UnlessCallable.html
[ValidationErrors]:             http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.ValidationErrors.html
[ValidationFailed]:             http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.ValidationFailed.html

[Between]:                      http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Between.html
[Blank]:                        http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Blank.html
[Email]:                        http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Email.html
[Equal]:                        http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Equal.html
[Identical]:                    http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Identical.html
[IsFalse]:                      http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.IsFalse.html
[IsNull]:                       http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.IsNull.html
[IsTrue]:                       http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.IsTrue.html
[JSON]:                         http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.JSON.html
[Max]:                          http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Max.html
[MaxLength]:                    http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.MaxLength.html
[Min]:                          http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Min.html
[MinLength]:                    http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.MinLength.html
[NotBetween]:                   http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.NotBetween.html
[NotBlank]:                     http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.NotBlank.html
[NotEqual]:                     http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.NotEqual.html
[NotIdentical]:                 http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.NotIdentical.html
[NotNull]:                      http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.NotNull.html
[Required]:                     http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Required.html
[TimeZone]:                     http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.TimeZone.html
[Type]:                         http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Type.html
[URL]:                          http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.URL.html
