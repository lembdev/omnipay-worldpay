<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardIssuer
{
    /**
     * The financial institution that issued the card
     *
     * @return string|null
     */
    public function getCardIssuer()
    {
        return $this->getResponseKey('paymentMethod.cardIssuer');
    }
}
