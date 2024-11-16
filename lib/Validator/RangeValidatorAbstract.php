<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\Render;

/**
 * Abstract for classes implementing range comparisons.
 */
abstract class RangeValidatorAbstract extends ValidatorAbstract
{
    public const PARAM_MIN = 'min';
    public const PARAM_MAX = 'max';

    public const MESSAGE_ARG_MIN = self::PARAM_MIN;
    public const MESSAGE_ARG_MAX = self::PARAM_MAX;
    public const MESSAGE_ARG_VALUE_TYPE = 'value_type';

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        $min = $context->param(self::PARAM_MIN);
        $max = $context->param(self::PARAM_MAX);

        $context->message_args[self::MESSAGE_ARG_MIN] = $min;
        $context->message_args[self::MESSAGE_ARG_MAX] = $max;
        $context->message_args[self::MESSAGE_ARG_VALUE_TYPE] = Render::render_type($min);

        return $this->compare($value, $min, $max);
    }

    /**
     * @inheritdoc
     */
    protected function get_params_mapping(): array
    {
        return [ self::PARAM_MIN, self::PARAM_MAX ];
    }

    /**
     * Compares a value to a reference.
     */
    abstract protected function compare(mixed $value, mixed $min, mixed $max): bool;
}
