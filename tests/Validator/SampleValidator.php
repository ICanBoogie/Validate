<?php

namespace ICanBoogie\Validate\Validator;

use ICanBoogie\Validate\Context;

class SampleValidator extends AbstractValidator
{
	const ALIAS = 'sample';
	const DEFAULT_MESSAGE = 'is not sample';

	/**
	 * @inheritdoc
	 */
	public function validate($value, callable $error, Context $context)
	{
		if ($value !== 'sample')
		{
			$error();
		}
	}
}
