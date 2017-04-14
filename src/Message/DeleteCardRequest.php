<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

class DeleteCardRequest extends AbstractRequest
{
    protected $endpointUri = '/tokens';

    /**
     * @inheritdoc
     * @return null
     */
    public function getData()
    {
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
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return AbstractResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->createRequest(EmptyResponse::class, $data);
    }
}