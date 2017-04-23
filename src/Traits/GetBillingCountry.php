<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

use lembdev\WorldPay\Helpers\CountryHelper;

trait GetBillingCountry
{
    /**
     * The issuer country code in ISO 3166 2-letter format
     *
     * @return string|null
     */
    public function getBillingCountryCode()
    {
        return $this->getResponseKey('paymentResponse.billingAddress.countryCode');
    }

    /**
     * The issuer country code in ISO 3166 2-letter format
     *
     * @return string|null
     * @throws \ErrorException
     */
    public function getBillingCountry()
    {
        $code = $this->getBillingCountryCode();
        return CountryHelper::getCodeByCountry($code);
    }
}