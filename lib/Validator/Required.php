<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * States that a value is required. When the value is not present the validator issues an error
 * and stops validation of the value, that is on error no other validator is run.
 */
class Required extends ValidatorAbstract
{
    public const ALIAS = 'required';
    public const DEFAULT_MESSAGE = "is required";

    /**
     * Whether a given value is empty.
     *
     * The following values are considered empty: an empty array, an empty trimmed string, `null`.
     * `false` and `0` are considered like valid values.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function is_empty($value)
    {
        if (is_array($value)) {
            return !count($value);
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        return $value === null;
    }

    /**
     * @inheritdoc
     */
    public function normalize_params(array $params): array
    {
        return array_merge([

            self::OPTION_STOP_ON_ERROR => true,

        ], parent::normalize_params($params));
    }

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        return !self::is_empty($value);
    }
}
