<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

use lembdev\WorldPay\Helpers\CountryHelper;

trait GetCardCountryCode
{
    /**
     * The issuer country code in ISO 3166 2-letter format
     *
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->getResponseKey('paymentMethod.countryCode');
    }

    /**
     * The issuer country code in ISO 3166 2-letter format
     *
     * @return string|null
     * @throws \ErrorException
     */
    public function getCountry()
    {
        $code = $this->getCountryCode();
        return CountryHelper::getCountryByCode($code);
    }
}