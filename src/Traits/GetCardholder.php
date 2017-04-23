<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardholder
{
    /**
     * The name of the cardholder or payee
     *
     * @return string|null
     */
    public function getCardholder()
    {
        return $this->getResponseKey('paymentMethod.name')
            ?: $this->getResponseKey('paymentResponse.name');
    }
}