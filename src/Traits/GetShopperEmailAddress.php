<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetShopperEmailAddress
{
    /**
     * Shopper Email Address
     *
     * @return string|null
     */
    public function getShopperEmailAddress()
    {
        return $this->getResponseKey('shopperEmailAddress');
    }
}