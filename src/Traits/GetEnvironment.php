<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetEnvironment
{
    /**
     * Indicates whether this order was made in the TEST or LIVE environment
     *
     * @return string|null
     */
    public function getEnvironment()
    {
        return $this->getResponseKey('environment');
    }
}