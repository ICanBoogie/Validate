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

use ICanBoogie\Validate\Validator;

/**
 * @small
 */
class IdenticalTest extends ComparisonValidatorTestCase
{
	const VALIDATOR_CLASS = Identical::class;

	/**
	 * @inheritdoc
	 */
	public function provide_test_valid_values()
	{
		$date = new \DateTime('2000-01-01');
		$object = (object) [ 'property' . uniqid() => uniqid() ];

		$comparisons = [
			[ 3, 3 ],
			[ 'a', 'a' ],
			[ $date, $date ],
			[ $object, $object ],
			[ null, 1 ],
		];

		$immutableDate = new \DateTimeImmutable('2000-01-01');
		$comparisons[] = [ $immutableDate, $immutableDate ];

		return $comparisons;
	}

	/**
	 * @inheritdoc
	 */
	public function provide_test_invalid_values()
	{
		return [
			[ 1, 2, 'integer' ],
			[ 2, '2', 'string' ],
			[ '22', '333', 'string' ],
			[ new \DateTime('2001-01-01'), new \DateTime('2001-01-01'), 'DateTime' ],
			[ new \DateTime('2001-01-01'), new \DateTime('1999-01-01'), 'DateTime' ],
			[ (object) [ 'property' => uniqid() ], (object) [ 'property' => uniqid() ], 'stdClass' ],
		];
	}
}
