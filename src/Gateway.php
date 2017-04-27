<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay;

use lembdev\WorldPay\Message\CardCreateRequest;
use lembdev\WorldPay\Message\CardDeleteRequest;
use lembdev\WorldPay\Message\CardFetchRequest;
use lembdev\WorldPay\Message\PurchaseRequest;
use lembdev\WorldPay\Message\RefundRequest;
use Omnipay\Common\AbstractGateway;

/**
 * WorldPay Gateway.
 *
 * Full example:
 *
 * ```php
 *   // Create a gateway for the WorldPay Gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('\\lembdev\\WorldPay\\Gateway');
 *
 *   // Initialise the gateway
 *   $gateway->initialize(array(
 *       'serviceKey' => 'MyServiceKey',
 *       'clientKey'  => 'MyClientKey',
 *   ));
 *
 *   $cc = new \Omnipay\Common\CreditCard([
 *       'name'        => 'EXAMPLE CUSTOMER',
 *       'number'      => '4444 3333 2222 1111',
 *       'expiryMonth' => 2,
 *       'expiryYear'  => 2025,
 *       'cvv'         => '123',
 *       'address1'    => 'Street name',
 *       'address2'    => 'optional address',
 *       'city'        => 'Some City',
 *       'postcode'    => '79016',
 *       'state'       => 'Some State',
 *       'country'     => 'USA',
 *       'phone'       => '+12010001155',
 *   ]);
 *
 *   $tokenTransaction = $gateway->createCard([
 *       'card'     => $cc,
 *       'reusable' => true,
 *   ]);
 *
 *   $tokenResponse = $tokenTransaction->send();
 *   if (!$tokenResponse->isSuccessful()) {
 *       throw new ErrorException($tokenResponse->getMessage());
 *   }
 *   $token = $tokenResponse->getToken();
 *
 *   // Do a purchase transaction on the gateway
 *   $transaction = $gateway->purchase(array(
 *       'amount'      => '10.00',
 *       'currency'    => 'USD',
 *       'description' => 'Order description',
 *       'token'       => $token
 *   ));
 *   // token - A unique token which the WorldPay.js library added to your checkout form,
 *   // or obtained via the token API. This token represents the customer's card details/payment method
 *   // which was stored on our server. One of token or paymentMethod must be specified
 *
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Purchase transaction was successful!\n";
 *
 *       $sale_id = $response->getTransactionReference();
 *       echo "Transaction reference = {$sale_id}\n";
 *   }
 * ```
 *
 * Test modes:
 * Setting the testMode flag on this gateway has no effect.
 *
 * @link https://developer.worldpay.com/jsonapi/api
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'WorldPay JSON';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'serviceKey' => '',
            'clientKey'  => '',
        ];
    }

    /**
     * Get the gateway Service Key.
     *
     * @return string
     */
    public function getServiceKey()
    {
        return $this->getParameter('serviceKey');
    }

    /**
     * Set the gateway Service Key.
     *
     * @param string $value
     *
     * @return Gateway
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setServiceKey($value)
    {
        return $this->setParameter('serviceKey', $value);
    }

    /**
     * Get the gateway Client Key.
     *
     * @return string
     */
    public function getClientKey()
    {
        return $this->getParameter('clientKey');
    }

    /**
     * Set the gateway Client Key.
     *
     * @param string $value
     *
     * @return Gateway
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setClientKey($value)
    {
        return $this->setParameter('clientKey', $value);
    }

    /**
     * @inheritdoc
     * @return PurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @inheritdoc
     * @return CardCreateRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function createCard(array $parameters = [])
    {
        return $this->createRequest(CardCreateRequest::class, $parameters);
    }

    /**
     * @inheritdoc
     * @return CardDeleteRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function deleteCard(array $parameters = [])
    {
        return $this->createRequest(CardDeleteRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return CardFetchRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function fetchCard(array $parameters = [])
    {
        return $this->createRequest(CardFetchRequest::class, $parameters);
    }

    /**
     * @inheritdoc
     * @throws \ErrorException
     */
    public function authorize(array $parameters = [])
    {
        throw new \ErrorException('Method not implemented');
    }

    /**
     * @inheritdoc
     * @throws \ErrorException
     */
    public function completeAuthorize(array $parameters = [])
    {
        throw new \ErrorException('Method not implemented');
    }

    /**
     * @inheritdoc
     * @throws \ErrorException
     */
    public function completePurchase(array $parameters = [])
    {
        throw new \ErrorException('Method not implemented');
    }

    /**
     * @inheritdoc
     * @throws \ErrorException
     */
    public function capture(array $parameters = [])
    {
        throw new \ErrorException('Method not implemented');
    }

    /**
     * @inheritdoc
     * @throws \ErrorException
     */
    public function void(array $parameters = [])
    {
        throw new \ErrorException('Method not implemented');
    }

    /**
     * @inheritdoc
     * @throws \ErrorException
     */
    public function updateCard(array $parameters = [])
    {
        throw new \ErrorException('Method not implemented');
    }

    /**
     * @inheritdoc
     *
     * @return RefundRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }
}
