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
 * ```php
 *   // Create a gateway for the WorldPay Gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('\\lembdev\\WorldPay\\Gateway');
 *
 *   // Initialise the gateway
 *   $gateway->initialize([
 *       'serviceKey' => 'T_S_2addbca3-d0a5-486c-9f83-3d64b6c73288',
 *       'clientKey'  => 'T_C_c27428cd-9005-4dd3-8f7e-734c06a79abd',
 *   ]);
 *
 *   // Create a credit card object
 *   $newCard = new CreditCard([
 *       'name'        => 'EXAMPLE CUSTOMER',
 *       'number'      => '4444 3333 2222 1111',
 *       'expiryMonth' => 2,
 *       'expiryYear'  => 2025,
 *       'cvv'         => '123',
 *       'issueNumber' => 1, // optional
 *       'startMonth'  => 2, // optional
 *       'startYear'   => 2013, // optional
 *   ]);
 *
 *   // Do a create card transaction on the gateway
 *   $response = $gateway->createCard([
 *       'card'     => $newCard,
 *       'reusable' => true,
 *   ])->send();
 *
 *   if ($response->isSuccessful()) {
 *       echo "Gateway createCard was successful.\n";
 *
 *       $cardToken = $response->getToken();
 *       echo "Credit Card token = {$cardToken}\n";
 *
 *       $cardDetails = $response->getCard();
 *   }
 * ```
 *
 * @method CardCreateResponse send()
 *
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
        $this->validate('clientKey', 'card');

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
     * @inheritdoc
     * @return CardCreateResponse|AbstractResponse
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
