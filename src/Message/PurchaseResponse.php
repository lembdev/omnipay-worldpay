<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

class PurchaseResponse extends AbstractResponse
{
    /**
     * A WorldPay generated unique order code.
     *
     * @return string|null
     */
    public function getOrderCode()
    {
        return $this->getResponseKey('orderCode');
    }

    /**
     * This token represents the customer's card details/payment method which was stored on our server.
     *
     * @return string|null
     */
    public function getToken()
    {
        return $this->getResponseKey('token');
    }

    /**
     * The description of the order provided by you
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getResponseKey('orderDescription');
    }

    /**
     * @return mixed|null
     */
    public function getAmount()
    {
        return $this->getResponseKey('amount');
    }

    /**
     * The ISO currency code of the currency you want to charge your customer in
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->getResponseKey('currencyCode');
    }

    /**
     * The current status of the Order.
     * Available statuses:
     * - SUCCESS: The order was created successfully and the funds were charged to the customer's account
     * - FAILED: The order was not successful
     * - SENT_FOR_REFUND: A full or part refund has been requested for the order and is being processed
     * - REFUNDED: The order has been wholly refunded to the customer
     * - PARTIALLY_REFUNDED: Part of the order value has been refunded to the customer
     * - AUTHORIZED: The order was authorised by the payment provider and the funds are reserved on the customer's account awaiting capture
     * - CANCELLED: The authorization has been cancelled and the funds released to the customer's account
     * - EXPIRED: The authorization expired and the funds released on the customer's account
     * - SETTLED: The order value has been received from the payment provider
     * - CHARGED_BACK: The customer disputed this order and the money was returned
     * - INFORMATION_REQUESTED: When WorldPay disputes a charge-back, we will ask you for supporting information and doumentation
     * - INFORMATION_SUPPLIED: You have supplied us information with which to dispute the charge-back
     *
     * @return string|null
     */
    public function getPaymentStatus()
    {
        return $this->getResponseKey('paymentStatus');
    }

    /**
     * The ISO currency code of the currency that you will be settled in.
     *
     * @return string|null
     */
    public function getSettlementCurrency()
    {
        return $this->getResponseKey('currencyCode');
    }

    /**
     * Indicates whether this order was made in the TEST or LIVE environment
     *
     * @return string|null
     */
    public function getEnvironment()
    {
        return $this->getResponseKey('environment');
    }

    /**
     * String defining the payment type "ObfuscatedCard" or "APM"
     *
     * @return string|null
     */
    public function getPaymentType()
    {
        return $this->getResponseKey('paymentResponse.type');
    }

    /**
     * The name of the cardholder or payee
     *
     * @return string|null
     */
    public function getPaymentName()
    {
        return $this->getResponseKey('paymentResponse.name');
    }

    /**
     * Expiry month of the card
     *
     * @return int|null
     */
    public function getPaymentExpiryMonth()
    {
        return $this->getResponseKey('paymentResponse.expiryMonth');
    }

    /**
     * Expiry year of the card
     *
     * @return int|null
     */
    public function getPaymentExpiryYear()
    {
        return $this->getResponseKey('paymentResponse.expiryYear');
    }

    /**
     * Type of the card that was used.
     * Worldpay returns the following Card Types:
     * - VISA_CREDIT: Visa Credit
     * - VISA_DEBIT: Visa Debit
     * - VISA_CORPORATE_CREDIT: Visa Corporate Credit
     * - VISA_CORPORATE_DEBIT: Visa Corporate Debit
     * - MASTERCARD_CREDIT: Mastercard Credit
     * - MASTERCARD_DEBIT: Mastercard Debit
     * - MASTERCARD_CORPORATE_CREDIT: Mastercard Corporate Credit
     * - MASTERCARD_CORPORATE_DEBIT: Mastercard Corporate Debit
     * - MAESTRO: Maestro
     * - AMEX: American Express
     * - CARTEBLEUE: Cartebleue
     * - JCB: JCB
     * - DINERS: Diners
     *
     * @return int|null
     */
    public function getPaymentCardType()
    {
        return $this->getResponseKey('paymentResponse.cardType');
    }

    /**
     * The last four digits of the card number with all other numbers masked
     *
     * @return string|null
     */
    public function getPaymentMaskedCardNumber()
    {
        return $this->getResponseKey('paymentResponse.maskedCardNumber');
    }

    /**
     * Indicates the card is either 'consumer' or 'corporate'
     *
     * @return string|null
     */
    public function getPaymentCardSchemeType()
    {
        return $this->getResponseKey('paymentResponse.cardSchemeType');
    }

    /**
     * Type of the card that was used.
     *
     * @return string|null
     */
    public function getPaymentCardSchemeName()
    {
        return $this->getResponseKey('paymentResponse.cardSchemeName');
    }

    /**
     * The financial institution that issued the card
     *
     * @return string|null
     */
    public function getPaymentCardIssuer()
    {
        return $this->getResponseKey('paymentResponse.cardIssuer');
    }

    /**
     * The issuer country code in ISO 3166 2-letter format
     *
     * @return string|null
     */
    public function getPaymentCountryCode()
    {
        return $this->getResponseKey('paymentResponse.countryCode');
    }

    /**
     * Indicates whether the card is 'credit' or 'debit'
     *
     * @return string|null
     */
    public function getPaymentCardClass()
    {
        return $this->getResponseKey('paymentResponse.cardClass');
    }

    /**
     * Product type detail for non-contactless cards
     *
     * @return string|null
     */
    public function getPaymentCardProductTypeDescNonContactless()
    {
        return $this->getResponseKey('paymentResponse.cardProductTypeDescNonContactless');
    }

    /**
     * Product type detail for contactless cards
     *
     * @return string|null
     */
    public function getPaymentCardProductTypeDescContactless()
    {
        return $this->getResponseKey('paymentResponse.cardProductTypeDescContactless');
    }

    /**
     * Indicates whether the card is prepaid
     *
     * @return string|null
     */
    public function getPaymentsPrepaid()
    {
        return $this->getResponseKey('paymentResponse.prepaid');
    }

    /**
     * The first line of the address.
     *
     * @return string|null
     */
    public function getDeliveryAddress1()
    {
        return $this->getResponseKey('deliveryAddress.address1');
    }

    /**
     * The second line of the address
     *
     * @return string|null
     */
    public function getDeliveryAddress2()
    {
        return $this->getResponseKey('deliveryAddress.address2');
    }

    /**
     * The postcode or ZIP code.
     *
     * @return string|null
     */
    public function getDeliveryPostalCode()
    {
        return $this->getResponseKey('deliveryAddress.postalCode');
    }

    /**
     * The postal town or city.
     *
     * @return string|null
     */
    public function getDeliveryCity()
    {
        return $this->getResponseKey('deliveryAddress.city');
    }

    /**
     * Subdivision of a country e.g. Schleswig-Holstein, Queensland
     *
     * @return string|null
     */
    public function getDeliveryState()
    {
        return $this->getResponseKey('deliveryAddress.state');
    }

    /**
     * The ISO 3166 alpha-2 2-letter country code.
     *
     * @return string|null
     */
    public function getDeliveryCountryCode()
    {
        return $this->getResponseKey('deliveryAddress.countryCode');
    }

    /**
     * The telephone number associated with the address.
     *
     * @return string|null
     */
    public function getDeliveryPhone()
    {
        return $this->getResponseKey('deliveryAddress.telephoneNumber');
    }

    /**
     * The first name of the deliveree
     *
     * @return string|null
     */
    public function getDeliveryFirstName()
    {
        return $this->getResponseKey('deliveryAddress.firstName');
    }

    /**
     * The family name of the deliveree
     *
     * @return string|null
     */
    public function getDeliveryLastName()
    {
        return $this->getResponseKey('deliveryAddress.lastName');
    }
}