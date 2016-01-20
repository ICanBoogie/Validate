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
class URLTest extends ValidatorTestCase
{
	const VALIDATOR_CLASS = URL::class;

	public function provide_test_valid_values()
	{
		return [
			[ 'http://a.pl' ],
			[ 'http://www.icanboogie.org' ],
			[ 'http://www.google.museum' ],
			[ 'https://icanboogie.org/' ],
			[ 'https://icanboogie.org:80/' ],
			[ 'http://www.example.coop/' ],
			[ 'http://www.test-example.com/' ],
			[ 'http://www.icanboogie.org/' ],
			[ 'http://symfony.fake/blog/' ],
			[ 'http://icanboogie.org/?' ],
			[ 'http://icanboogie.org/search?type=&q=url+validator' ],
			[ 'http://icanboogie.org/#' ],
			[ 'http://icanboogie.org/#?' ],
			[ 'http://www.icanboogie.org/doc/current/book/validation.html#supported-constraints' ],
			[ 'http://very.long.domain.name.com/' ],
			[ 'http://localhost/' ],
			[ 'http://127.0.0.1/' ],
			[ 'http://127.0.0.1:80/' ],
			[ 'http://xn--sopaulo-xwa.com/' ],
			[ 'http://xn--sopaulo-xwa.com.br/' ],
			[ 'http://xn--e1afmkfd.xn--80akhbyknj4f/' ],
			[ 'http://xn--mgbh0fb.xn--kgbechtv/' ],
			[ 'http://xn--fsqu00a.xn--0zwm56d/' ],
			[ 'http://xn--fsqu00a.xn--g6w251d/' ],
			[ 'http://xn--r8jz45g.xn--zckzah/' ],
			[ 'http://xn--mgbh0fb.xn--hgbk6aj7f53bba/' ],
			[ 'http://xn--9n2bp8q.xn--9t4b11yi5a/' ],
			[ 'http://xn--ogb.idn.icann.org/' ],
			[ 'http://xn--e1afmkfd.xn--80akhbyknj4f.xn--e1afmkfd/' ],
			[ 'http://xn--espaa-rta.xn--ca-ol-fsay5a/' ],
			[ 'http://xn--d1abbgf6aiiy.xn--p1ai/' ],
			[ 'http://username:password@icanboogie.org' ],
			[ 'http://user-name@icanboogie.org' ],
			[ 'http://icanboogie.org?' ],
			[ 'http://icanboogie.org?query=1' ],
			[ 'http://icanboogie.org/?query=1' ],
			[ 'http://icanboogie.org#' ],
			[ 'http://icanboogie.org#fragment' ],
			[ 'http://icanboogie.org/#fragment' ],
		];
	}

	public function provide_test_invalid_values()
	{
		return [
			[ null ],
			[ '' ],
			[ new \stdClass ],
			[ 1 ],
			[ 'icanboogie.org' ],
			[ '://icanboogie.org' ],
			[ 'http ://icanboogie.org' ],
			[ 'http:/icanboogie.org' ],
			[ 'http://i_can_boogie.com' ],
			[ 'http://icanboogie.org::aa' ],
			[ 'http://icanboogie.org:aa' ],
			[ 'http://127.0.0.1:aa/' ],
			[ 'http://[::1' ],
			[ 'http://hello.☎/' ],
			[ 'http://username:passwordicanboogie.org' ],
		];
	}
}
