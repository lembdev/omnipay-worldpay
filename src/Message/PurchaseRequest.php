<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Guzzle\Common\Exception\InvalidArgumentException;
use Omnipay\Common\CreditCard;

class PurchaseRequest extends AbstractRequest
{
    protected $endpointUri = '/orders';

    /**
     * @param string $country
     *
     * @return string
     * @throws \Guzzle\Common\Exception\InvalidArgumentException
     */
    protected static function getCountryCodeByName($country)
    {
        if (!$country) {
            return null;
        }

        $countries = include __DIR__ . '/../country_iso_code.php';

        $countryCode = array_search($country, $countries, true);

        if (!$countryCode) {
            throw new InvalidArgumentException('Incorrect country or country code not found');
        }

        return $countryCode;
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
        $this->validate('amount');
        $this->validate('currency');
        $this->validate('description');
        $this->validate('clientKey');

        $billingAddress = $this->getAddressArray('billing');
        $billingAddress = $this->arrayFilter($billingAddress);

        $deliveryAddress = $this->getAddressArray('delivery');
        $deliveryAddress = $this->arrayFilter($deliveryAddress);

        $data = [
            'billingAddress'      => $billingAddress ?: null,
            'deliveryAddress'     => $deliveryAddress ?: null,
            'token'               => $this->getToken(),
            'orderType'           => $this->getOrderType(),
            'amount'              => (int)$this->getAmount() * 100,
            'currencyCode'        => $this->getCurrency(),
            'orderDescription'    => $this->getDescription(),
            'settlementCurrency'  => $this->getCurrency(),
            'name'                => $this->getCard()->getName(),
            'customerOrderCode'   => null, // TODO
            'shopperEmailAddress' => null, // TODO
            'shopperIpAddress'    => null, // TODO
            'shopperSessionId'    => null, // TODO
        ];

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
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return AbstractResponse
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
        if (!in_array($target, ['billing', 'delivery', ''], true)) {
            throw new InvalidArgumentException('target must be one of this: \'billing\', \'delivery\'');
        }

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
}