<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

/**
 * WorldPay Create Credit Card Request.
 *
 * ### Example
 *
 * <code>
 *   // Create a credit card object
 *   $newCard = new CreditCard(array(
 *       'name'        => 'EXAMPLE CUSTOMER',
 *       'number'      => '4444 3333 2222 1111',
 *       'expiryMonth' => 2,
 *       'expiryYear'  => 2025,
 *       'cvv'         => '123',
 *       'issueNumber' => 1, // optional
 *       'startMonth'  => 2, // optional
 *       'startYear'   => 2013, // optional
 *   ));
 *
 *   // Do a create card transaction on the gateway
 *   $response = $gateway->createCard(array(
 *       'card'     => $newCard,
 *       'reusable' => true,
 *   ))->send();
 *
 *   if ($response->isSuccessful()) {
 *       echo "Gateway createCard was successful.\n";
 *       $cardData = [
 *           'card_token'       => $response->getToken(),
 *           'cardType'         => $response->getCardType()
 *           'maskedCardNumber' => $response->getMaskedCardNumber()
 *           'cardClass'        => $response->getCardClass()
 *       ];
 *       var_dump($cardData);
 *   }
 * </code>
 *
 * @method CardCreateResponse send()
 *
 * @see  CreateCustomerRequest
 * @link https://stripe.com/docs/api#create_card
 */
class CardCreateRequest extends AbstractRequest
{
    protected $endpointUri = '/tokens';

    /**
     * @inheritdoc
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     */
    public function getData()
    {
        $this->validate('card');
        $this->validate('clientKey');

        $this->getCard()->validate();

        $paymentMethod = [
            'type'        => 'Card',
            'name'        => $this->getCard()->getName(),
            'expiryMonth' => $this->getCard()->getExpiryMonth(),
            'expiryYear'  => $this->getCard()->getExpiryYear(),
            'issueNumber' => $this->getCard()->getIssueNumber(),
            'startMonth'  => $this->getCard()->getStartMonth(),
            'startYear'   => $this->getCard()->getStartYear(),
            'cardNumber'  => $this->getCard()->getNumber(),
            'cvc'         => $this->getCard()->getCvv(),
        ];

        return [
            'reusable'      => $this->getReusable(),
            'clientKey'     => $this->getClientKey(),
            'paymentMethod' => $this->arrayFilter($paymentMethod)
        ];
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return AbstractResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->createRequest(CardCreateResponse::class, $data);
    }

    /**
     * Get is token reusable
     *
     * @return bool
     */
    public function getReusable()
    {
        return $this->getParameter('reusable');
    }

    /**
     * Set is token reusable.
     * Indicating whether the token should be used only once
     *
     * @param bool $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setReusable($value)
    {
        return $this->setParameter('reusable', $value);
    }

    /**
     * Return request headers
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Content-type' => 'application/json',
        ];
    }
}