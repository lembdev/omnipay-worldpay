<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetDescription
{
    /**
     * The description of the order provided by you
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getResponseKey('orderDescription');
    }
}