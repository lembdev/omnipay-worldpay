<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

/**
 * WorldPay Delete Credit Card Request.
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
 *       'serviceKey' => 'MyServiceKey',
 *       'clientKey'  => 'MyClientKey',
 *   ]);
 *
 *   // Do a delete card transaction on the gateway
 *   $response = $gateway->deleteCard([
 *       'token' => 'CARD_TOKEN',
 *   ])->send();
 *
 *   if ($response->isSuccessful()) {
 *       echo "Gateway deleteCard was successful.\n";
 *   } else {
 *       echo $response->getMessage();
 *   }
 * ```
 *
 * @method CardDeleteResponse send()
 */
class CardDeleteRequest extends AbstractRequest
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
        return 'DELETE';
    }

    /**
     * @inheritdoc
     * @return CardDeleteResponse|AbstractResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->createRequest(CardDeleteResponse::class, $data);
    }
}
