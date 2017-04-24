<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetReusable
{
    /**
     * Get is token reusable
     *
     * @return bool
     */
    public function getReusable()
    {
        $reusable = $this->getResponseKey('reusable');
        return $reusable !== null
            ? filter_var($this->getResponseKey('reusable'), FILTER_VALIDATE_BOOLEAN)
            : null;
    }
}
