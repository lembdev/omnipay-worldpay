<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardSchemeName
{
    /**
     * Type of the card that was used
     *
     * @return string|null
     */
    public function getCardSchemeName()
    {
        return $this->getResponseKey('paymentMethod.cardSchemeName');
    }
}
