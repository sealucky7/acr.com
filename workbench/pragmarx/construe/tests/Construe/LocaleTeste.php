<?php

/**
 * Part of the Construe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Construe
 * @version    1.0.0
 * @author     Antonio Carlos Ribeiro @ PragmaRX
 * @license    BSD License (3-clause)
 * @copyright  (c) 2013, PragmaRX
 * @link       http://pragmarx.com
 */

use PragmaRX\Construe\Support\Locale;

class LocaleTest extends PHPUnit_Framework_TestCase {

	public function setup()
	{
		$this->locale = new Locale;
	}

	public function testLocaleGotEnglishUS()
	{
		$this->assertEquals($this->locale->getLanguage(), 'en');

		$this->assertEquals($this->locale->getCountry(), 'us');
	}

	public function testLocaleGettersAndSetters()
	{
		$this->locale->setLanguage('pt');

		$this->locale->setCountry('br');

		$this->assertEquals($this->locale->getLanguage(), 'pt');
		
		$this->assertEquals($this->locale->getCountry(), 'br');
	}

	public function testLocaleConstructor()
	{
		$locale = new Locale('pt', 'br');

		$this->assertEquals($locale->getLanguage(), 'pt');
		
		$this->assertEquals($locale->getCountry(), 'br');
	}

}