# Validate

[![Release](https://img.shields.io/packagist/v/icanboogie/validate.svg)](https://packagist.org/packages/icanboogie/validate)
[![Build Status](https://img.shields.io/travis/ICanBoogie/Validate.svg)](http://travis-ci.org/ICanBoogie/Validate)
[![Code Quality](https://img.shields.io/scrutinizer/g/icanboogie/validate.svg)](https://scrutinizer-ci.com/g/ICanBoogie/Validate)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/Validate.svg)](https://coveralls.io/r/ICanBoogie/Validate)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/validate.svg)](https://packagist.org/packages/icanboogie/validate)

The **icanboogie/validate** package offers a simple API to validate data.

The following validators are available:

- Flags

	- [Required][], `required`: States that a value is required. Should be specified first.

- Generic

	- [Blank][], `blank`: Validates that a value is blank.
	- [NotBlank][], `not-blank`: Validates that a value is blank.

- Type comparison

	- [Boolean][], `boolean`: Validates that a value is a boolean.
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
	- [BetweenLength][], `between-length`: Validates that a string length is between two references.
	- [NotBetweenLength][], `not-between-length`: Validates that a string length is not between two references.

- String comparison

	- [Email][], `email`: Validates that a value is a valid email.
	- [JSON][], `json`: Validates that a value is a valid JSON.
	- [Regex][], `regex`: Validates that a value matches or not a pattern.
	- [TimeZone][], `timezone`: Validates that a value is a valid time zone.
	- [URL][], `url`: Validates that a value is a valid URL.

The following example demonstrates how data may be validated:

```php
<?php

use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\Reader\ArrayAdapter;

$validation = new Validation([
	'name' => 'required|min-length:3',
	'email' => 'required|email!|unique',
	'password' => 'required|min-length:6',
	'consent' => 'required',
]);

$errors = $validation->validate(new ArrayAdapter([
	'name' => "Ol",
	'email' => "olivier",
	'password' => "123",
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
    array(4) {
      'attribute' =>
      string(4) "name"
      'value' =>
      string(2) "Ol"
      'validator' =>
      string(39) "ICanBoogie\Validate\Validator\MinLength"
      'reference' =>
      string(1) "3"
    }
  }
}
string(36) "should be at least 3 characters long"
```





## Validation

A validation is defined using an array of key/value pairs where _key_ is an attribute to validate
and _key_ is the rules. Rules may be defined as a string or an array of key/value pairs where _key_
is a validator class, or alias, and _value_ an array of parameters and options. Optionally you may
provide a validator provider, if you don't, an instance of [BuiltinValidatorProvider][] is created
by default.

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

$validation = new Validation([
	'name' => [
		Validator\Required::class => [],
		Validator\MinLength::class => [ Validator\MinLength::PARAM_REFERENCE => 3 ],
	]
]);
```





### Empty values, required attributes

It is important to know that validators are not run on empty values, unless the `required` validator
is used too. The following values are considered _empty_: `null`, an empty array, an empty trimmed
string; but `false` and `0` are considered valid values.

The following example demonstrates how `required` influences validation:

```php
<?php

use ICanBoogie\Validate\Reader\ArrayAdapter;
use ICanBoogie\Validate\Validation;

$validation = new Validation([

	'required_tz' => 'required|timezone',
	'optional_tz' => 'timezone',

]);

$errors =$validation->validate(new ArrayAdapter([

	'required_tz' => '',
	'optional_tz' => '',

]));

isset($errors['required_tz']); // true
isset($errors['optional_tz']); // false
```





### Validating data

The `validate()` method validates data. It returns a [ValidationErrors][] instance if the validation
failed, an empty array otherwise.

```php
<?php

use ICanBoogie\Validate\Reader\RequestAdapter;
use ICanBoogie\Validate\Validation;

/* @var $validation Validation */

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

The `assert()` method may be used to assert that data is valid. Instead of returning a
[ValidationErrors][] instance like `validate()`, the method throws a [ValidationFailed][] exception.
The validation errors may be retrieved from the exception using its `errors` property.

```php
<?php

use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\ValidationFailed;
use ICanBoogie\Validate\Reader\RequestAdapter;

/* @var $validation Validation */

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

- `ValidatorOptions::OPTION_MESSAGE`: A custom error message, which overrides the validator default
message.

- `ValidatorOptions::OPTION_IF`: The validator is used only if the callable defined by this option
returns `true`. The callable may be a closure or an instance implementing the [IfCallable][]
interface.

- `ValidatorOptions::OPTION_UNLESS`: The validator is skipped if the callable defined by this option
returns `true`. The callable may be a closure or an instance implementing the [UnlessCallable][]
interface.

- `ValidatorOptions::OPTION_STOP_ON_ERROR`: If `true`, the validation of a value stops after an
error. This option is always `true` for the [Required][] validator.

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
				return $context->value('name');
			},
			Required::OPTION_UNLESS => function(Context $context) {
				return !$context->value('register');
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

The validation context is represented by a [Context][] instance and is passed along with the value
to validate to the validator. The validator may used the context to retrieve parameters and options,
and when required get a complete picture of the ongoing validation.

The following properties are available:

- `attribute`: The attribute being validated.
- `value`: The value of the attribute being validated.
- `validator`: The current validator.
- `validator_params`: The parameters and options for the current validator.
- `reader`: A [Reader][] adapter giving access to the values being validated.
- `message`: The possible error message for the current validator.
- `message_args`: The arguments for the possible error message.
- `errors`: The collected errors.

The following example demonstrates how a validator may retrieve its parameters and options from the
context, and a value from the value reader:

```php
<?php

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\Validator\ValidatorAbstract;

class SampleValidator extends ValidatorAbstract
{
	const PARAM_REFERENCE = 'reference';
	const OPTION_STRICT = 'strict';

	/**
	 * @inheritdoc
	 */
	public function validate($value, Context $context)
	{
		$reference = $context->param(self::PARAM_REFERENCE);
		$strict = $context->option(self::OPTION_STRICT, false);
		$other_value = $context->value('some_other_value');
	}
}
```





## Validator provider

Validator instances are obtained using a _validator provider_. By default, an instance of
[BuiltinValidatorProvider][] is used, but you can provide your own provider, or better, a provider
collection.

The following example demonstrates how to use the builtin provider:

```php
<?php

use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\ValidatorProvider\BuiltinValidatorProvider;

/* @var $rules array */

$builtin_validator_provider = new BuiltinValidatorProvider;
$validation = new Validation($rules, $builtin_validator_provider);

# or

$validation = new Validation($rules);
```

The following example demonstrates how to provide your own `sample` validator: 

```php
<?php

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\Validator;

/* @var $sample_validator Validator */

$rules = [ 'attribute' => $sample_validator::ALIAS ];
$sample_validator_provider = function ($class_or_alias) use ($sample_validator) {

	switch ($class_or_alias)
	{
		case get_class($sample_validator):
		case $sample_validator::ALIAS:
			return $sample_validator;

		default:
			throw new UndefinedValidator($class_or_alias);
	}

};

$validation = new Validation($rules, $sample_validator_provider);
```

The following example demonstrates how to provide validators using a container:

```php
<?php

use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\ValidatorProvider\ContainerValidatorProvider;
use Psr\Container\ContainerInterface;

/* @var $rules array */
/* @var $container ContainerInterface */

$prefix = 'validator.';
$container_validator_provider = new ContainerValidatorProvider($container, $prefix);

$validation = new Validation($rules, $container_validator_provider);
```

The following example demonstrates how to use a number of providers as a collection:
 
```php
<?php

use ICanBoogie\Validate\Validation;
use ICanBoogie\Validate\ValidatorProvider\BuiltinValidatorProvider;
use ICanBoogie\Validate\ValidatorProvider\ContainerValidatorProvider;
use ICanBoogie\Validate\ValidatorProvider\ValidatorProviderCollection;

/* @var $rules array */
/* @var $container_validator_provider ContainerValidatorProvider */
/* @var $sample_validator_provider callable */
/* @var $builtin_validator_provider BuiltinValidatorProvider */

$validator_provider_collection = new ValidatorProviderCollection([

	$container_validator_provider,
	$sample_validator_provider,
	$builtin_validator_provider,

]);
 
$validation = new Validation($rules, $validator_provider_collection);
```





----------





## Requirements

The package requires PHP 5.5 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/):

	$ composer require icanboogie/validate





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





[ICanBoogie]:                   https://icanboogie.org/
[documentation]:                https://icanboogie.org/api/validate/master/
[BuiltinValidatorProvider]:     https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.ValidatorProvider.BuiltinValidatorProvider.html
[Context]:                      https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Context.html
[Reader]:                       https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Reader.html
[Validation]:                   https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validation.html
[IfCallable]:                   https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validation.IfCallable.html
[UnlessCallable]:               https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validation.UnlessCallable.html
[ValidationErrors]:             https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.ValidationErrors.html
[ValidationFailed]:             https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.ValidationFailed.html

[Between]:                      https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Between.html
[BetweenLength]:                https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.BetweenLength.html
[Blank]:                        https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Blank.html
[Boolean]:                      https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Boolean.html
[Email]:                        https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Email.html
[Equal]:                        https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Equal.html
[Identical]:                    https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Identical.html
[IsFalse]:                      https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.IsFalse.html
[IsNull]:                       https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.IsNull.html
[IsTrue]:                       https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.IsTrue.html
[JSON]:                         https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.JSON.html
[Max]:                          https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Max.html
[MaxLength]:                    https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.MaxLength.html
[Min]:                          https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Min.html
[MinLength]:                    https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.MinLength.html
[NotBetween]:                   https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.NotBetween.html
[NotBetweenLength]:             https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.NotBetweenLength.html
[NotBlank]:                     https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.NotBlank.html
[NotEqual]:                     https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.NotEqual.html
[NotIdentical]:                 https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.NotIdentical.html
[NotNull]:                      https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.NotNull.html
[Regex]:                        https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Regex.html
[Required]:                     https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Required.html
[TimeZone]:                     https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.TimeZone.html
[Type]:                         https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.Type.html
[URL]:                          https://icanboogie.org/api/validate/master/class-ICanBoogie.Validate.Validator.URL.html
