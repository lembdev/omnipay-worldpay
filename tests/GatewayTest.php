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

//    public function testPurchase()
//    {
//        $request = $this->gateway->purchase(['amount' => '10.00']);
//        $this->assertInstanceOf(Message\PurchaseRequest::class, $request);
//        $this->assertSame('10.00', $request->getAmount());
//    }
}