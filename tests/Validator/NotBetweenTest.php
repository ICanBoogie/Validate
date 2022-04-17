<?php

namespace ICanBoogie\Validate\Validator;

class NotBetweenTest extends BetweenTest
{
	const VALIDATOR_CLASS = NotBetween::class;

	/**
	 * @inheritdoc
	 */
	public function provide_test_valid_values()
	{
		return parent::provide_test_invalid_values();
	}

	/**
	 * @inheritdoc
	 */
	public function provide_test_invalid_values(): array
    {
		return parent::provide_test_valid_values();
	}
}
