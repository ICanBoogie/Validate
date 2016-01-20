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

use ICanBoogie\Validate\Context;
use ICanBoogie\Validate\ParameterIsMissing;
use ICanBoogie\Validate\Validator;

/**
 * @small
 */
class TypeTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = Type::class;

	/**
	 * @dataProvider provide_test_valid_values
	 *
	 * @param mixed $value
	 * @param string|array $type
	 */
	public function test_valid_values($value, $type = [])
	{
		parent::test_valid_values($value, [ Type::PARAM_TYPE => $type ]);
		parent::test_valid_values($value, [ $type ]);
	}

	public function provide_test_valid_values()
	{
		$object = new \stdClass();
		$file = fopen(__FILE__, 'r');

		return [
			[ null, 'null' ],
			[ 1, 'integer' ],
			[ '', 'string' ],
			[ true, 'Boolean' ],
			[ false, 'Boolean' ],
			[ true, 'boolean' ],
			[ false, 'boolean' ],
			[ true, 'bool' ],
			[ false, 'bool' ],
			[ 0, 'numeric' ],
			[ '0', 'numeric' ],
			[ 1.5, 'numeric' ],
			[ '1.5', 'numeric' ],
			[ 0, 'integer' ],
			[ 1.5, 'float' ],
			[ '12345', 'string' ],
			[ [ ], 'array' ],
			[ $object, 'object' ],
			[ $object, 'stdClass' ],
			[ $file, 'resource' ],
			[ '12345', 'digit' ],
			[ '12a34', 'alnum' ],
			[ 'abcde', 'alpha' ],
			[ "\n\r\t", 'cntrl' ],
			[ 'arf12', 'graph' ],
			[ 'abcde', 'lower' ],
			[ 'ABCDE', 'upper' ],
			[ 'arf12', 'print' ],
			[ '*&$()', 'punct' ],
			[ "\n\r\t", 'space' ],
			[ 'AB10BC99', 'xdigit' ],
		];
	}

	/**
	 * @dataProvider provide_test_invalid_values
	 *
	 * @param mixed $value
	 * @param string|array $type
	 */
	public function test_invalid_values($value, $type = [])
	{
		parent::test_invalid_values($value, [ Type::PARAM_TYPE => $type ]);
		parent::test_invalid_values($value, [ $type ]);
	}

	public function provide_test_invalid_values()
	{
		$object = new \stdClass();
		$file = fopen(__FILE__, 'r');

		return [
			[ 'foobar', 'numeric' ],
			[ 'foobar', 'boolean' ],
			[ '0', 'integer' ],
			[ '1.5', 'float' ],
			[ 12345, 'string' ],
			[ $object, 'boolean' ],
			[ $object, 'numeric' ],
			[ $object, 'integer' ],
			[ $object, 'float' ],
			[ $object, 'string' ],
			[ $object, 'resource' ],
			[ $file, 'boolean' ],
			[ $file, 'numeric' ],
			[ $file, 'integer' ],
			[ $file, 'float' ],
			[ $file, 'string' ],
			[ $file, 'object' ],
			[ '12a34', 'digit' ],
			[ '1a#23', 'alnum' ],
			[ 'abcd1', 'alpha' ],
			[ "\nabc", 'cntrl' ],
			[ "abc\n", 'graph' ],
			[ 'abCDE', 'lower' ],
			[ 'ABcde', 'upper' ],
			[ "\nabc", 'print' ],
			[ 'abc&$!', 'punct' ],
			[ "\nabc", 'space' ],
			[ 'AR1012', 'xdigit' ],
		];
	}

	public function test_missing_param()
	{
		$validator = new Type;

		try
		{
			$validator->validate(uniqid(), new Context);
		}
		catch (ParameterIsMissing $e)
		{
			$this->assertStringEndsWith('::PARAM_TYPE', $e->parameter);

			return;
		}

		$this->fail("Expected ParameterIsMissing");
	}
}
