<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardStartMonth
{
    /**
     * Start month of the card. This field is only used for some types of debit cards
     *
     * @return int|null
     */
    public function getStartMonth()
    {
        $startMonth = $this->getResponseKey('paymentMethod.startMonth');

        return $startMonth === null ? null : (int)$startMonth;
    }
}