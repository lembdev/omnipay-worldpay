<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardSchemeType
{
    /**
     * Indicates the card is either 'consumer' or 'corporate'
     *
     * @return string|null
     */
    public function getCardSchemeType()
    {
        return $this->getResponseKey('paymentMethod.cardSchemeType');
    }
}