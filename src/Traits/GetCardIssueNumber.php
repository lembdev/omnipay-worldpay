<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetCardIssueNumber
{
    /**
     * Issue number on the card. This field is only used for some types of debit cards
     *
     * @return int|null
     */
    public function getIssueNumber()
    {
        $issueNumber = $this->getResponseKey('paymentMethod.issueNumber');

        return $issueNumber === null ? null : (int)$issueNumber;
    }
}
