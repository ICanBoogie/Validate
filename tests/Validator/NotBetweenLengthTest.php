<?php

namespace ICanBoogie\Validate\Validator;

class NotBetweenLengthTest extends BetweenLengthTest
{
	const VALIDATOR_CLASS = NotBetweenLength::class;

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
	public function provide_test_invalid_values()
	{
		return parent::provide_test_valid_values();
	}
}
