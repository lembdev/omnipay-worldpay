<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardProductTypeDescNonContactless
{
    /**
     * Product type detail for non-contactless cards
     *
     * @return string|null
     */
    public function getCardProductTypeDescNonContactless()
    {
        return $this->getResponseKey('paymentMethod.cardProductTypeDescNonContactless');
    }
}