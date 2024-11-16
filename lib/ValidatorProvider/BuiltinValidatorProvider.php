<?php

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\Validator;

/**
 * Provides aliases to builtin validators.
 */
class BuiltinValidatorProvider extends SimpleValidatorProvider
{
    /**
     * Alias mapping to builtin validators.
     *
     * **Note**: The array is defined without the help of `Validator::ALIAS` so that we don't autoload a bunch of
     * classes for nothing. Unit tests make sure that the right aliases are used.
     */
    private const BUILTIN_VALIDATORS = [

        'between' => Validator\Between::class,
        'between-length' => Validator\BetweenLength::class,
        'blank' => Validator\Blank::class,
        'boolean' => Validator\Boolean::class,
        'email' => Validator\Email::class,
        'equal' => Validator\Equal::class,
        'identical' => Validator\Identical::class,
        'is-false' => Validator\IsFalse::class,
        'is-null' => Validator\IsNull::class,
        'is-true' => Validator\IsTrue::class,
        'json' => Validator\JSON::class,
        'max' => Validator\Max::class,
        'max-length' => Validator\MaxLength::class,
        'min' => Validator\Min::class,
        'min-length' => Validator\MinLength::class,
        'not-between' => Validator\NotBetween::class,
        'not-between-length' => Validator\NotBetweenLength::class,
        'not-blank' => Validator\NotBlank::class,
        'not-equal' => Validator\NotEqual::class,
        'not-identical' => Validator\NotIdentical::class,
        'not-null' => Validator\NotNull::class,
        'regex' => Validator\Regex::class,
        'required' => Validator\Required::class,
        'timezone' => Validator\TimeZone::class,
        'type' => Validator\Type::class,
        'url' => Validator\URL::class,

    ];

    /**
     * Adds aliases to builtin validator classes.
     *
     * @inheritdoc
     */
    public function __construct(array $aliases = [])
    {
        parent::__construct($aliases + self::BUILTIN_VALIDATORS);
    }
}
