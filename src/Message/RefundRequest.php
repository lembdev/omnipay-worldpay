<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

/**
 * WorldPay Purchase Request.
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
 *   // Do a refund transaction on the gateway
 *   $transaction = $gateway->refund([
 *       'orderCode'       => 'ORDER_CODE',
 *       'refundAmount'    => 10.00
 *   ]);
 *
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Refund transaction was successful!\n";
 *   } else {
 *       echo $response->getMessage();
 *   }
 * ```
 * @method RefundResponse send()
 */
class RefundRequest extends AbstractRequest
{
    protected $endpointUri = '/orders';

    /**
     * @return string
     */
    public function getOrderCode()
    {
        return $this->getParameter('orderCode');
    }

    /**
     * @param string $orderCode
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setOrderCode($orderCode)
    {
        return $this->setParameter('orderCode', $orderCode);
    }

    /**
     * @inheritdoc
     * @return null
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('serviceKey', 'orderCode');

        $refundAmount = $this->getRefundAmount();

        return $refundAmount ? ['refundAmount' => $refundAmount * 100] : null;
    }

    /**
     * @param float|int $refundAmount
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setRefundAmount($refundAmount)
    {
        return $this->setParameter('refundAmount', $refundAmount);
    }

    /**
     * @return float|int
     */
    public function getRefundAmount()
    {
        return $this->getParameter('refundAmount');
    }

    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/' . $this->getOrderCode() . '/refund';
    }

    /**
     * @inheritdoc
     * @return RefundResponse|AbstractResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->createRequest(RefundResponse::class, $data);
    }
}
