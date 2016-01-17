<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Validate\Validator;

class AbstractComparisonValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function test_missing_param()
	{
		$validator = $this
			->getMockBuilder(AbstractComparisonValidator::class)
			->getMockForAbstractClass();

		/* @var $validator AbstractComparisonValidator */

		try
		{
			$validator->normalize_options([ ]);
		}
		catch (ParameterIsMissing $e)
		{
			$this->assertStringEndsWith('::PARAM_REFERENCE', $e->parameter);

			return;
		}

		$this->fail("Expected ParameterIsMissing");
	}
}
