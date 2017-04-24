<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

/**
 * Class CardFetchRequest
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
        $this->validate('token');

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
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return AbstractResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->createRequest(CardFetchResponse::class, $data);
    }
}
