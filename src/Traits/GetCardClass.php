<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardClass
{
    /**
     * Indicates whether the card is 'credit' or 'debit'
     *
     * @return string|null
     */
    public function getCardClass()
    {
        return $this->getResponseKey('paymentMethod.cardClass');
    }
}
