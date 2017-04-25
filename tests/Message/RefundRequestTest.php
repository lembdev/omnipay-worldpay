<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /** @var RefundRequest */
    protected $request;

    public function setUp()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setServiceKey('test_service_key');
        $this->request->setOrderCode('TEST_ORDER_CODE');
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }

    public function testSendFail()
    {
        $this->setMockHttpResponse('RefundFail.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('BAD_REQUEST', $response->getCode());
    }
}