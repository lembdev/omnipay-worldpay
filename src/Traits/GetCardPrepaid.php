<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardPrepaid
{
    /**
     * Indicates whether the card is prepaid
     *
     * @return bool|null
     */
    public function getPrepaid()
    {
        $prepaid = $this->getResponseKey('paymentMethod.prepaid');

        return $prepaid === null ? null : $prepaid === 'true';
    }
}
