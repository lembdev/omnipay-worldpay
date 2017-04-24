<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardExpiryMonth
{
    /**
     * Expiry month of the card
     *
     * @return int|null
     */
    public function getExpiryMonth()
    {
        $expiryMonth = $this->getResponseKey('paymentMethod.expiryMonth')
                ?: $this->getResponseKey('paymentResponse.expiryMonth');

        return $expiryMonth === null ? null : (int)$expiryMonth;
    }
}
