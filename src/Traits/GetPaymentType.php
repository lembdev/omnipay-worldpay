<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetPaymentType
{
    /**
     * String defining the payment type "ObfuscatedCard" or "APM"
     *
     * @return string|null
     */
    public function getPaymentType()
    {
        return $this->getResponseKey('paymentResponse.type');
    }
}