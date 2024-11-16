<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value matches a regular expression.
 */
class Regex extends ValidatorAbstract
{
    public const ALIAS = 'regex';
    public const DEFAULT_MESSAGE = "`{value}` does not match pattern";

    public const PARAM_PATTERN = 'pattern';
    public const OPTION_NOT_MATCH = 'not_match';

    public const MESSAGE_ARG_PATTERN = 'pattern';

    public const NOT_MATCH = true;
    public const MATCH = false;

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        $pattern = $context->param(self::PARAM_PATTERN);
        $not_match = $context->option(self::OPTION_NOT_MATCH);

        $context->message_args[self::MESSAGE_ARG_PATTERN] = $pattern;

        $result = preg_match($pattern, $value);

        return $not_match ? $result !== 1 : $result === 1;
    }

    /**
     * @inheritdoc
     */
    protected function get_params_mapping(): array
    {
        return [ self::PARAM_PATTERN, self::OPTION_NOT_MATCH ];
    }
}
