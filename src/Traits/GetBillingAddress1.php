<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetBillingAddress1
{
    /**
     * The first line of the billing address.
     *
     * @return string|null
     */
    public function getBillingAddress1()
    {
        return $this->getResponseKey('paymentMethod.address1')
            ?: $this->getResponseKey('paymentResponse.billingAddress.address1');
    }
}
