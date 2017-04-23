<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Helpers;

use Omnipay\Tests\TestCase;

class CountryHelperTest extends TestCase
{
    public function testGetCodeByCountry()
    {
        $this->assertNull(CountryHelper::getCodeByCountry());
        $this->assertEquals('UA', CountryHelper::getCodeByCountry('Ukraine'));

        try {
            CountryHelper::getCodeByCountry('Unknown');
        } catch (\Exception $e) {
            $this->getExpectedException();
        }
    }

    public function testGetCountryByCode()
    {
        $this->assertNull(CountryHelper::getCountryByCode());
        $this->assertEquals('Ukraine', CountryHelper::getCountryByCode('UA'));

        try {
            CountryHelper::getCountryByCode('Unknown');
        } catch (\Exception $e) {
            $this->getExpectedException();
        }
    }
}