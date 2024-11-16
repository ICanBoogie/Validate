<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\Render;

/**
 * Abstract for classes implementing value comparison.
 */
abstract class ComparisonValidatorAbstract extends ValidatorAbstract
{
    public const PARAM_REFERENCE = 'reference';

    public const MESSAGE_ARG_REFERENCE = self::PARAM_REFERENCE;
    public const MESSAGE_ARG_VALUE_TYPE = 'value_type';

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        $reference = $context->param(self::PARAM_REFERENCE);

        $context->message_args[self::MESSAGE_ARG_REFERENCE] = $reference;
        $context->message_args[self::MESSAGE_ARG_VALUE_TYPE] = Render::render_type($reference);

        return $this->compare($value, $reference);
    }

    /**
     * @inheritdoc
     */
    protected function get_params_mapping(): array
    {
        return [ self::PARAM_REFERENCE ];
    }

    /**
     * Compares a value to a reference.
     */
    abstract protected function compare(mixed $value, mixed $reference): bool;
}
