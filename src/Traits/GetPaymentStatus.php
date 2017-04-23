<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Traits;

trait GetPaymentStatus
{
    /**
     * The current status of the Order.
     * Available statuses:
     * - SUCCESS: The order was created successfully and the funds were charged to the customer's account
     * - FAILED: The order was not successful
     * - SENT_FOR_REFUND: A full or part refund has been requested for the order and is being processed
     * - REFUNDED: The order has been wholly refunded to the customer
     * - PARTIALLY_REFUNDED: Part of the order value has been refunded to the customer
     * - AUTHORIZED: The order was authorised by the payment provider and the funds are reserved on the customer's
     * account awaiting capture
     * - CANCELLED: The authorization has been cancelled and the funds released to the customer's account
     * - EXPIRED: The authorization expired and the funds released on the customer's account
     * - SETTLED: The order value has been received from the payment provider
     * - CHARGED_BACK: The customer disputed this order and the money was returned
     * - INFORMATION_REQUESTED: When WorldPay disputes a charge-back, we will ask you for supporting information and
     * documentation
     * - INFORMATION_SUPPLIED: You have supplied us information with which to dispute the charge-back
     *
     * @return string|null
     */
    public function getPaymentStatus()
    {
        return $this->getResponseKey('paymentStatus');
    }
}