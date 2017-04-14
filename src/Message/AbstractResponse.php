<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * Transaction Id
     *
     * @var string
     */
    protected $transactionReference;

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return !array_key_exists('httpStatusCode', $this->data) || $this->data['httpStatusCode'] === 200;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return isset($this->data['message'])
            ? $this->data['message']
            : $this->getResponseKey('description');
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->getResponseKey('customCode');
    }

    /**
     * Get transaction Id
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->transactionReference;
    }

    /**
     * Set transaction Id
     *
     * @param string $transactionReference
     */
    public function setTransactionReference($transactionReference)
    {
        $this->transactionReference = $transactionReference;
    }

    /**
     * Return response data value if request is successful
     * The key may be specified in a dot format to retrieve the value of a sub-array or the property
     * of an embedded object. In particular, if the key is `x.y.z`, then the returned value would
     * be `$array['x']['y']['z']`
     *
     * @param string     $key     name of the array element
     * @param mixed      $default the default value to be returned if the specified array key does not exist.
     * @param array|null $array   array to extract value from. Default to $this->data
     *
     * @return mixed|null
     */
    protected function getResponseKey($key, $default = null, $array = null)
    {
        if (!$this->isSuccessful()) {
            return $default;
        }

        $array = $array ?: $this->data;

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $array = $this->getResponseKey(substr($key, 0, $pos), $default, $array);
            $key = substr($key, $pos + 1);
        }

        if (is_array($array)) {
            return array_key_exists($key, $array) ? $array[$key] : $default;
        }

        return $default;
    }
}