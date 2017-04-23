<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCurrencyCode
{
    /**
     * The ISO currency code of the currency that you will be settled in.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->getResponseKey('currencyCode');
    }
}