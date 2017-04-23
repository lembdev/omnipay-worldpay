<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * @property AbstractResponse $response
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Endpoint URL
     *
     * @var string URL
     */
    protected $endpoint = 'https://api.worldpay.com/v1';
    protected $endpointUri;

    /**
     * Get transaction endpoint.
     *
     * Authorization of payments is done using the /orders resource.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint . $this->endpointUri;
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
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setClientKey($value)
    {
        return $this->setParameter('clientKey', $value);
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
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setServiceKey($value)
    {
        return $this->setParameter('serviceKey', $value);
    }

    /**
     * Return Guzzle HTTP Client
     *
     * @return \Guzzle\Http\ClientInterface
     */
    protected function getHttpClient()
    {
        // Use TLS >= v1.2
        $config = $this->httpClient->getConfig();
        $curlOptions = $config->get('curl.options');
        $curlOptions[CURLOPT_SSLVERSION] = 6;
        $config->set('curl.options', $curlOptions);
        $this->httpClient->setConfig($config);

        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                /** @var $event \Symfony\Component\EventDispatcher\Event */
                /** @var $response \Guzzle\Http\Message\Response */
                $response = $event['response'];
                if ($response->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        return $this->httpClient;
    }

    /**
     * Create and send request
     *
     * @param string $responseClass
     * @param array  $data The data to send
     *
     * @return AbstractResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    protected function createRequest($responseClass, array $data = null)
    {
        try {
            $httpResponse = $this->getHttpClient()->createRequest(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                $this->getHeaders(),
                $this->toJSON($data)
            )->send();

            // Fix error json_decode empty string
            $httpResponseData = (string) $httpResponse->getBody() ? $httpResponse->json() : [];

            $httpResponseData['httpStatusCode'] = $httpResponse->getStatusCode();

            $this->response = new $responseClass($this, $httpResponseData);

            if ($httpResponse->hasHeader('requestId')) {
                $this->response->setTransactionReference((string)$httpResponse->getHeader('requestId'));
            }

            return $this->response;
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                "Error communicating with payment gateway: {$e->getMessage()}",
                $e->getCode()
            );
        }
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * Returns object JSON representation
     *
     * @param array $data
     *
     * @return string
     */
    protected function toJSON($data)
    {
        return $data ? json_encode($data) : null;
    }

    /**
     * Return request headers
     *
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Content-type'  => 'application/json',
            'Authorization' => $this->getServiceKey(),
        ];
    }

    /**
     * Remove empty rows from array
     *
     * @param $array
     *
     * @return array
     */
    protected function arrayFilter(array $array)
    {
        return array_filter($array, function($v) {
            return $v !== null;
        });
    }
}
