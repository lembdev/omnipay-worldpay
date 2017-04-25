<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

class RefundRequest extends AbstractRequest
{
    protected $endpointUri = '/orders';

    public function getOrderCode()
    {
        return $this->getParameter('orderCode');
    }

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

        return null;
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
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->createRequest(EmptyResponse::class, $data);
    }
}