<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardType
{
    /**
     * Type of the card that was used.
     *
     * @return string|null
     */
    public function getCardType()
    {
        return $this->getResponseKey('paymentMethod.cardType')
            ?: $this->getResponseKey('paymentResponse.cardType');
    }
}