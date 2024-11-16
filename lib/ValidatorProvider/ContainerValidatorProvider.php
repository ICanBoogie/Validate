<?php

namespace ICanBoogie\Validate\ValidatorProvider;

use ICanBoogie\Validate\UndefinedValidator;
use ICanBoogie\Validate\Validator;
use ICanBoogie\Validate\ValidatorProvider;
use Psr\Container\ContainerInterface;

readonly class ContainerValidatorProvider implements ValidatorProvider
{
    public function __construct(
        private ContainerInterface $container,
        private string $prefix = '',
    ) {
    }

    /**
     * @inheritdoc
     */
    public function __invoke(string $class_or_alias): Validator
    {
        $alias = $this->resolve_alias($class_or_alias);
        $id = $this->prefix . $alias;

        if (!$this->container->has($id)) {
            throw new UndefinedValidator($class_or_alias);
        }

        return $this->container->get($id);
    }

    /**
     * @param string|class-string<Validator> $class_or_alias
     *
     * @return string The alias for the validator.
     */
    private function resolve_alias(string $class_or_alias): string
    {
        if (class_exists($class_or_alias)) {
            /* @var $class_or_alias Validator */

            return $class_or_alias::ALIAS;
        }

        return $class_or_alias;
    }
}
