<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetBillingPostcode
{
    /**
     * The billing postcode or ZIP code.
     *
     * @return string|null
     */
    public function getBillingPostcode()
    {
        return $this->getResponseKey('paymentResponse.billingAddress.postalCode');
    }
}