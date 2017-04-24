<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardProductTypeDescContactless
{
    /**
     * Product type detail for contactless cards.
     *
     * @return string|null
     */
    public function getCardProductTypeDescContactless()
    {
        return $this->getResponseKey('paymentMethod.cardProductTypeDescContactless');
    }
}
