<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardStartYear
{
    /**
     * Start year of the card. This field is only used for some types of debit cards
     *
     * @return string|null
     */
    public function getStartYear()
    {
        $startYear = $this->getResponseKey('paymentMethod.startYear');

        return $startYear === null ? null : (int)$startYear;
    }
}
