<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\Validator;

/**
 * Abstract validator.
 */
abstract class ValidatorAbstract implements Validator
{
    /**
     * @inheritdoc
     */
    public function normalize_params(array $params): array
    {
        foreach ($this->get_params_mapping() as $index => $param) {
            if (isset($params[$index])) {
                $params[$param] = $params[$index];

                unset($params[$index]);
            }
        }

        return $params;
    }

    /**
     * @inheritdoc
     */
    abstract public function validate(mixed $value, Context $context): bool;

    /**
     * Returns indexed parameters mapping.
     *
     * @return string[]
     */
    protected function get_params_mapping(): array
    {
        return [];
    }
}
