<?php

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator;

/**
 * Provide simple validators, without dependencies.
 */
class SimpleValidatorProvider
{
    /**
     * @param array<string, class-string<Validator>> $aliases
     *     Where _key_ is an alias and _value_ a validator class.
     */
    public function __construct(
        private readonly array $aliases = []
    ) {
    }

    /**
     * @var array<class-string<Validator>, Validator>
     */
    private array $instances = [];

    /**
     * Returns a validator.
     *
     * @param string|class-string<Validator> $class_or_alias
     */
    public function __invoke(string $class_or_alias): Validator
    {
        $class = $this->map($class_or_alias);

        return $this->instances[$class] ??= $this->instantiate($class);
    }

    /**
     * Tries to map a validator alias into a validator class.
     *
     * @param string|class-string<Validator> $class_or_alias The class or alias of a validator.
     *
     * @return class-string<Validator>
     */
    protected function map(string $class_or_alias): string
    {
        /** @var class-string<Validator> */
        return $this->aliases[$class_or_alias] ?? $class_or_alias;
    }

    /**
     * Instantiates a validator.
     *
     * @param class-string<Validator> $class
     */
    protected function instantiate(string $class): Validator
    {
        if (!class_exists($class)) {
            throw new UndefinedValidator($class);
        }

        return new $class();
    }
}
