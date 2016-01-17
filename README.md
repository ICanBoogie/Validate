# Validate

[![Release](https://img.shields.io/packagist/v/icanboogie/validate.svg)](https://packagist.org/packages/icanboogie/validate)
[![Build Status](https://img.shields.io/travis/ICanBoogie/validate/master.svg)](http://travis-ci.org/ICanBoogie/validate)
[![HHVM](https://img.shields.io/hhvm/icanboogie/validate.svg)](http://hhvm.h4cc.de/package/icanboogie/validate)
[![Code Quality](https://img.shields.io/scrutinizer/g/icanboogie/validate.svg)](https://scrutinizer-ci.com/g/ICanBoogie/validate)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/validate.svg)](https://coveralls.io/r/ICanBoogie/validate)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/validate.svg)](https://packagist.org/packages/icanboogie/validate)

The **icanboogie/validate** offers a simple API to validate data.

```php
<?php

use ICanBoogie\Validate\Validations;
use ICanBoogie\Validate\ValueReader\ArrayValueReader;

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





## Validations

Validations may be defined as a validation string or as an array of key/value pairs where _key_ is a validator class or validator alias, and _value_ is validator options.

```php
<?php

use ICanBoogie\Validate\Validations;

$validations = new Validations([

	'name' => 'required|min-length:3',

]);

# or

$validations = new Validations([

	'name' => [
	
		'required' => [],
		'min-length' => [ 3 ],
	]
	
]);

# or

use ICanBoogie\Validate\Validator;

$validations = new Validations([

	'name' => [
	
		Validator\Required::class => [],
		Validator\MinLength::class => [ 3 ],
	]
	
]);

# or

use ICanBoogie\Validate\Validator;

$validations = new Validations([

	'name' => [
	
		Validator\Required::class => [],
		Validator\MinLength::class => [ Validator\MinLength::PARAM_REFERENCE => 3 ],
	]

]);
```





## Special validation options

The following validation options may be defined:

- `ValidatorOptions::OPTION_MESSAGE`: A custom error message, which overrides the validator default message.

- `ValidatorOptions::OPTION_IF`: The validator is used only if the callable defined by this option returns `true`.

- `ValidatorOptions::OPTION_UNLESS`: The validator is skipped if the callable defined by this option returns `true`.

- `ValidatorOptions::OPTION_STOP_ON_ERROR`: If `true`, the validation of a value stops after an error. This option is always `true` for the [Require][] validator.

```php
<?php

use ICanBoogie\Validate\Validations;
use ICanBoogie\Validate\Validator\Required;
use ICanBoogie\Validate\Validator\Email;

$validations = new Validations([

	'email' => [
	
		Required::class => [
	
			Required::OPTION_MESSAGE => "The field E-Mail is required if your wish to register.",

			Required::OPTION_IF => function() use (&$values) {
			
				return isset($values['name'])
			
			},
			
			Required::OPTION_UNLESS => function() use (&$values) {
			
				return empty($values['register'])
			
			},
			
			Required::OPTION_STOP_ON_ERROR => true // already defined by Require
		
		],
		
		Email::class => [
	
			Email::OPTION_MESSAGE => "{value} is an invalid email address for the field E-Mail.",

		]
	
	]

]);
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

[![Build Status](https://img.shields.io/travis/ICanBoogie/validate/master.svg)](https://travis-ci.org/ICanBoogie/validate)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/validate.svg)](https://coveralls.io/r/ICanBoogie/validate)





## License

**icanboogie/validate** is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[documentation]:                http://api.icanboogie.org/validate/latest/
[Required]:                     http://api.icanboogie.org/validate/latest/class-ICanBoogie.Validate.Validator.Required.html