<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetBillingCity
{
    /**
     * The billing postal town or city.
     *
     * @return string|null
     */
    public function getBillingCity()
    {
        return $this->getResponseKey('paymentResponse.billingAddress.city');
    }
}