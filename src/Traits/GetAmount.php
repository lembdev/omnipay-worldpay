<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetAmount
{
    /**
     * @return mixed|null
     */
    public function getAmount()
    {
        return $this->getResponseKey('amount');
    }
}