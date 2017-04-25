<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Guzzle\Common\Exception\InvalidArgumentException;
use lembdev\WorldPay\Helpers\CountryHelper;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    protected $endpointUri = '/orders';

    /**
     * @param string $country
     *
     * @return string
     * @throws \Guzzle\Common\Exception\InvalidArgumentException
     */
    protected static function getCountryCodeByName($country = null)
    {
        return CountryHelper::getCodeByCountry($country);
    }

    /**
     * Get the type of order you will be placing
     *
     * @return string
     */
    public function getOrderType()
    {
        return $this->getParameter('orderType') ?: 'ECOM';
    }

    /**
     * Set the type of order you will be placing.
     * Available types:
     *   `ECOM` - the default value for an order
     *   `RECURRING` - set the order to be of type recurring
     *   `MOTO` - set the order to be of type Mail Order Telephone Order / Virtual Terminal
     *
     * @param string $orderType
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     * @throws \Guzzle\Common\Exception\InvalidArgumentException
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setOrderType($orderType)
    {
        if ($orderType !== null) {
            $orderType = strtoupper($orderType);
        }

        if (!in_array($orderType, ['ECOM', 'RECURRING', 'MOTO'], true)) {
            throw new InvalidArgumentException('orderType must be one of this: \'ECOM\', \'RECURRING\', \'MOTO\'');
        }

        return $this->setParameter('orderType', $orderType);
    }

    /**
     * @inheritdoc
     * @return array
     * @throws \Guzzle\Common\Exception\InvalidArgumentException
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @throws \Omnipay\Common\Exception\InvalidCreditCardException
     */
    public function getData()
    {
        $this->validate('serviceKey', 'amount', 'currency', 'description');

        $token = $this->parameters->get('token');
        $card = $this->parameters->get('card');

        if (!$token && !$card) {
            throw new InvalidRequestException('The token or paymentMethod parameter is required');
        }

        $billingAddress = $this->getAddressArray('billing');
        $billingAddress = $this->arrayFilter($billingAddress);

        $deliveryAddress = $this->getAddressArray('delivery');
        $deliveryAddress = $this->arrayFilter($deliveryAddress);

        $data = [
            'billingAddress'      => $billingAddress ?: null,
            'deliveryAddress'     => $deliveryAddress ?: null,
            'orderType'           => $this->getOrderType(),
            'amount'              => (int)$this->getAmount() * 100,
            'currencyCode'        => $this->getCurrency(),
            'orderDescription'    => $this->getDescription(),
            'settlementCurrency'  => $this->getCurrency(),
            'name'                => $this->getCard()->getName(),
            'customerOrderCode'   => null, // TODO
            'shopperEmailAddress' => null, // TODO
            'shopperIpAddress'    => $this->getClientIpAddress(),
            'shopperSessionId'    => null, // TODO
        ];

        if ($token) {
            $data['token'] = $this->getToken();
        } else {
            $data['paymentMethod'] = $this->arrayFilter([
                'type'        => 'Card',
                'name'        => $this->getCard()->getName(),
                'expiryMonth' => $this->getCard()->getExpiryMonth(),
                'expiryYear'  => $this->getCard()->getExpiryYear(),
                'issueNumber' => $this->getCard()->getIssueNumber(),
                'startMonth'  => $this->getCard()->getStartMonth(),
                'startYear'   => $this->getCard()->getStartYear(),
                'cardNumber'  => $this->getCard()->getNumber(),
                'cvc'         => $this->getCard()->getCvv()
            ]);
        }

        return $this->arrayFilter($data);
    }

    /**
     * @inheritdoc
     */
    public function getCard()
    {
        return parent::getCard() ?: new CreditCard();
    }

    /**
     * @inheritdoc
     * @return PurchaseResponse|AbstractResponse
     * @throws \Omnipay\Common\Exception\InvalidResponseException
     */
    public function sendData($data)
    {
        return $this->createRequest(PurchaseResponse::class, $data);
    }

    /**
     * Return billingAddress or deliveryAddress array
     *
     * @param string $target billing or delivery
     *
     * @return array
     * @throws \Guzzle\Common\Exception\InvalidArgumentException
     */
    protected function getAddressArray($target)
    {
        $target = $target === 'delivery' ? 'Shipping' : ucfirst($target);

        $card = $this->getCard();

        $country = $card->{"get{$target}Country"}();

        $data = [
            'address1'        => $card->{"get{$target}Address1"}(),
            'address2'        => $card->{"get{$target}Address2"}(),
            'postalCode'      => $card->{"get{$target}Postcode"}(),
            'city'            => $card->{"get{$target}City"}(),
            'state'           => $card->{"get{$target}State"}(),
            'countryCode'     => static::getCountryCodeByName($country),
            'telephoneNumber' => $card->{"get{$target}Phone"}(),
        ];

        if ($target === 'Shipping') {
            $data['firstName'] = $card->{"get{$target}FirstName"}();
            $data['lastName'] = $card->{"get{$target}LastName"}();
        }

        return $data;
    }

    /**
     * Client IP address
     *
     * @return string
     */
    protected function getClientIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}
