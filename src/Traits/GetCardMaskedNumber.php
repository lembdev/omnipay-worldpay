<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardMaskedNumber
{
    /**
     * The last four digits of the card number with all other numbers masked
     *
     * @return string|null
     */
    public function getMaskedCardNumber()
    {
        return $this->getResponseKey('paymentMethod.maskedCardNumber')
            ?: $this->getResponseKey('paymentResponse.maskedCardNumber');
    }
}