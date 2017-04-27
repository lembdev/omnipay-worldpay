<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

/**
 * WorldPay Delete Credit Card Request.
 *
 * Token details can be obtained by sending a get request.
 *
 * ### Example
 *
 * ```php
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('\\lembdev\\WorldPay\\Gateway');
 *
 *   // Initialise the gateway
 *   $gateway->initialize([
 *       'serviceKey' => 'MyServiceKey',
 *       'clientKey'  => 'MyClientKey',
 *   ]);
 *
 *   // Do a fetch card transaction on the gateway
 *   $response = $gateway->fetchCard([
 *       'token' => 'CARD_TOKEN',
 *   ])->send();
 *
 *   if ($response->isSuccessful()) {
 *       echo "Gateway createCard was successful.\n";
 *
 *       $cardToken = $response->getToken();
 *       echo "Credit Card token = {$cardToken}\n";
 *
 *       $cardDetails = $response->getCard();
 *   } else {
 *       echo $response->getMessage();
 *   }
 * ```
 *
 * @method CardFetchResponse send()
 */
class CardFetchRequest extends AbstractRequest
{
    protected $endpointUri = '/tokens';

    /**
     * @inheritdoc
     * @return null
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('serviceKey', 'token');

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/' . $this->getToken();
    }

    /**
     * @inheritdoc
     */
    public function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * @inheritdoc
     * @return CardFetchResponse|AbstractResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->createRequest(CardFetchResponse::class, $data);
    }
}
