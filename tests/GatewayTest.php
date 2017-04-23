<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay;

use Omnipay\Tests\GatewayTestCase;

/**
 * @property Gateway gateway
 */
class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testCardCreate()
    {
        $request = $this->gateway->createCard();
        $this->assertInstanceOf(Message\CardCreateRequest::class, $request);
    }

    public function testCardDelete()
    {
        $request = $this->gateway->deleteCard();
        $this->assertInstanceOf(Message\CardDeleteRequest::class, $request);
    }

    public function testCardFetch()
    {
        $request = $this->gateway->fetchCard();
        $this->assertInstanceOf(Message\CardFetchRequest::class, $request);
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase();
        $this->assertInstanceOf(Message\PurchaseRequest::class, $request);
    }
}