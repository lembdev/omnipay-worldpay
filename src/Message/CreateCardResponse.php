<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

class CreateCardResponse extends AbstractResponse
{
    /**
     * Indicates whether the card is 'credit' or 'debit'
     *
     * @return string|null
     */
    public function getCardClass()
    {
        return $this->getResponseKey('paymentMethod.cardClass');
    }

    /**
     * The financial institution that issued the card
     *
     * @return string|null
     */
    public function getCardIssuer()
    {
        return $this->getResponseKey('paymentMethod.cardIssuer');
    }

    /**
     * Product type detail for contactless cards.
     *
     * @return string|null
     */
    public function getCardProductTypeDescContactless()
    {
        return $this->getResponseKey('paymentMethod.cardProductTypeDescContactless');
    }

    /**
     * Product type detail for non-contactless cards
     *
     * @return string|null
     */
    public function getCardProductTypeDescNonContactless()
    {
        return $this->getResponseKey('paymentMethod.cardProductTypeDescNonContactless');
    }

    /**
     * Get card token
     *
     * @return null
     */
    public function getToken()
    {
        return $this->getResponseKey('token');
    }

    /**
     * Type of the card that was used
     *
     * @return string|null
     */
    public function getCardSchemeName()
    {
        return $this->getResponseKey('paymentMethod.cardSchemeName');
    }

    /**
     * Indicates the card is either 'consumer' or 'corporate'
     *
     * @return string|null
     */
    public function getCardSchemeType()
    {
        return $this->getResponseKey('paymentMethod.cardSchemeType');
    }

    /**
     * Type of the card that was used.
     *
     * @return string|null
     */
    public function getCardType()
    {
        return $this->getResponseKey('paymentMethod.cardType');
    }

    /**
     * The issuer country code in ISO 3166 2-letter format
     *
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->getResponseKey('paymentMethod.countryCode');
    }

    /**
     * Expiry month of the card
     *
     * @return int|null
     */
    public function getExpiryMonth()
    {
        $expiryMonth = $this->getResponseKey('paymentMethod.expiryMonth');

        return $expiryMonth === null ? null : (int)$expiryMonth;
    }

    /**
     * Expiry year of the card
     *
     * @return int|null
     */
    public function getExpiryYear()
    {
        $expiryYear = $this->getResponseKey('paymentMethod.expiryYear');

        return $expiryYear === null ? null : (int)$expiryYear;
    }

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

    /**
     * The last four digits of the card number with all other numbers masked
     *
     * @return string|null
     */
    public function getMaskedCardNumber()
    {
        return $this->getResponseKey('paymentMethod.maskedCardNumber');
    }

    /**
     * The name of the cardholder or payee
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getResponseKey('paymentMethod.name');
    }

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

    /**
     * Boolean indicating whether the token should be used only once (false) or multiple times (true)
     *
     * @return bool
     */
    public function getReusable()
    {
        $reusable = $this->getResponseKey('reusable');

        return $reusable === null ? null : $reusable === 'true';
    }

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

    /**
     * String defining the token type - "ObfuscatedCard" or "APM"
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->getResponseKey('paymentMethod.type');
    }
}