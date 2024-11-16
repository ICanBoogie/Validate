<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;
use PHPUnit\Framework\Attributes\Small;

class SampleValidator extends ValidatorAbstract
{
    public const ALIAS = 'sample';
    public const DEFAULT_MESSAGE = 'is not sample';

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        return $value === 'sample';
    }
}
