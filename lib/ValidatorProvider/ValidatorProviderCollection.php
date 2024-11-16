<?php

namespace ICanBoogie\Validate\ValidatorProvider;

use ArrayIterator;
use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator;
use ICanBoogie\Validate\ValidatorProvider;
use IteratorAggregate;
use Traversable;

/**
 * A collection of validator providers.
 *
 * @implements IteratorAggregate<ValidatorProvider|(callable(string):Validator)>
 */
class ValidatorProviderCollection implements ValidatorProvider, IteratorAggregate
{
    /**
     * @param array<ValidatorProvider|(callable(string):Validator)> $providers
     */
    public function __construct(
        private array $providers = []
    ) {
    }

    /**
     * @inheritdoc
     */
    public function __invoke(string $class_or_alias): Validator
    {
        foreach ($this->providers as $provider) {
            try {
                return $provider($class_or_alias);
            } catch (UndefinedValidator) {
                // Continue with the next provider
            }
        }

        throw new UndefinedValidator($class_or_alias);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->providers);
    }

    /**
     * @return $this
     */
    public function add(callable $provider): static
    {
        array_unshift($this->providers, $provider);

        return $this;
    }
}
