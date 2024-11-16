<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

/**
 * Validates that a value is a valid time zone.
 *
 * **Note**: This class validates _time zone_ such as "Europe/Paris" **NOT** _time zone offsets_ such as "+02:00".
 */
class TimeZone extends ValidatorAbstract
{
    public const ALIAS = 'timezone';
    public const DEFAULT_MESSAGE = "`{value}` is not a valid time zone, did you mean `{suggestion}`?";

    /**
     * @inheritdoc
     */
    public function validate(mixed $value, Context $context): bool
    {
        $identifiers = timezone_identifiers_list();

        if (in_array($value, $identifiers)) {
            return true;
        }

        $context->message_args['suggestion'] = $this->find_best_match($value, $identifiers);

        return false;
    }

    /**
     * Find the best possible match.
     *
     * @param string[] $identifiers
     */
    private function find_best_match(string $value, array $identifiers): string
    {
        $matches = array_fill_keys($identifiers, 0);

        foreach ($identifiers as $identifier) {
            similar_text($identifier, $value, $matches[$identifier]);
        }

        arsort($matches);

        /** @var string */
        return key($matches);
    }
}
