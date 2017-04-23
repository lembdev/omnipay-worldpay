<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetToken
{
    /**
     * Get card token
     *
     * @return null
     */
    public function getToken()
    {
        return $this->getResponseKey('token');
    }
}