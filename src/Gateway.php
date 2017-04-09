<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'WordPay JSON';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'serviceKey' => '',
            'clientKey'  => '',
            'testMode'   => false,
        ];
    }

    public function getServiceKey()
    {
        return $this->getParameter('serviceKey');
    }

    public function setServiceKey($value)
    {
        return $this->setParameter('serviceKey', $value);
    }

    public function getClientKey()
    {
        return $this->getParameter('clientKey');
    }

    public function setClientKey($value)
    {
        return $this->setParameter('clientKey', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\WorldPay\Message\CompletePurchaseRequest', $parameters);
    }
}