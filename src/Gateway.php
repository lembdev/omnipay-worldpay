<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay;

use lembdev\WorldPay\Message\AuthorizeRequest;
use lembdev\WorldPay\Message\CaptureRequest;
use lembdev\WorldPay\Message\PurchaseRequest;
use lembdev\WorldPay\Message\CreateCardRequest;
use lembdev\WorldPay\Message\RefundRequest;
use lembdev\WorldPay\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;

/**
 * WorldPay Gateway.
 *
 * Full example:
 *
 * <code>
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
 *       throw new Error($tokenResponse->getMessage());
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
 *       $sale_id = $response->getTransactionReference();
 *       echo "Transaction reference = " . $sale_id . "\n";
 *   }
 * </code>
 *
 * Test modes:
 *
 * Setting the testMode flag on this gateway has no effect.
 *
 * @see \Omnipay\Common\AbstractGateway
 * @see \lembdev\WorldPay\Message\AbstractRequest
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
     * Create a purchase request.
     *
     * @link https://developer.worldpay.com/jsonapi/docs/make-payment
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Create Card.
     *
     * This call can be used to create a new customer or add a card
     * to an existing customer.  If a customerReference is passed in then
     * a card is added to an existing customer.  If there is no
     * customerReference passed in then a new customer is created.  The
     * response in that case will then contain both a customer token
     * and a card token, and is essentially the same as CreateCustomerRequest
     *
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\RequestInterface
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest(CreateCardRequest::class, $parameters);
    }



//    /**
//     * Create an authorization request.
//     *
//     * To collect payment at a later time, first authorize a payment using the /payment resource.
//     * You can then capture the payment to complete the sale and collect payment.
//     *
//     * @link https://developer.worldpay.com/jsonapi/docs/authorize-payment
//     *
//     * @param array $parameters
//     *
//     * @return \lembdev\WorldPay\Message\AuthorizeRequest
//     */
//    public function authorize(array $parameters = [])
//    {
//        return $this->createRequest(AuthorizeRequest::class, $parameters);
//    }
//
//    /**
//     * Void an authorization.
//     *
//     * To to void a previously authorized payment.
//     *
//     * @link https://developer.worldpay.com/jsonapi/docs/authorize-payment
//     *
//     * @param array $parameters
//     *
//     * @return \lembdev\WorldPay\Message\VoidRequest
//     */
//    public function void(array $parameters = [])
//    {
//        return $this->createRequest(VoidRequest::class, $parameters);
//    }
//
//    /**
//     * Capture an authorization.
//     *
//     * Use this resource to capture and process a previously created authorization.
//     * To use this resource, the original payment call must have the intent set to
//     * authorize.
//     *
//     * @link https://developer.worldpay.com/jsonapi/docs/authorize-payment
//     *
//     * @param array $parameters
//     *
//     * @return \lembdev\WorldPay\Message\CaptureRequest
//     */
//    public function capture(array $parameters = [])
//    {
//        return $this->createRequest(CaptureRequest::class, $parameters);
//    }
//
//    /**
//     * Refund a Sale Transaction
//     *
//     * @link https://developer.worldpay.com/jsonapi/docs/refunds
//     *
//     * @param array $parameters
//     *
//     * @return \lembdev\WorldPay\Message\RefundRequest
//     */
//    public function refund(array $parameters = [])
//    {
//        return $this->createRequest(RefundRequest::class, $parameters);
//    }
}