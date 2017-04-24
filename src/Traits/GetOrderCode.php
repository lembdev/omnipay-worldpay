<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetOrderCode
{
    /**
     * A WorldPay generated unique order code.
     *
     * @return string|null
     */
    public function getOrderCode()
    {
        return $this->getResponseKey('orderCode');
    }
}
