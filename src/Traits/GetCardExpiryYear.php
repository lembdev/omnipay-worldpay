<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardExpiryYear
{
    /**
     * Expiry year of the card
     *
     * @return int|null
     */
    public function getExpiryYear()
    {
        $expiryYear = $this->getResponseKey('paymentMethod.expiryYear')
            ?: $this->getResponseKey('paymentResponse.expiryYear');

        return $expiryYear === null ? null : (int)$expiryYear;
    }
}
