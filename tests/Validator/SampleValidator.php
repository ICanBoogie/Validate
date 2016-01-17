<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Validator\AbstractValidator;

class SampleValidator extends AbstractValidator
{
	const ALIAS = 'sample';
	const DEFAULT_MESSAGE = 'is not sample';

	/**
	 * @inheritdoc
	 */
	public function validate($value, array $options, callable $error)
	{
		if ($value !== 'sample')
		{
			$error();
		}
	}
}
