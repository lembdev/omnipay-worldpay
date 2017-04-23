<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /** @var PurchaseRequest */
    protected $request;

    public function testSetters()
    {
        $this->initRequest([
            'amount'      => '10.00',
            'currency'    => 'USD',
            'token'       => 'your-token',
            'description' => 'order-description'
        ]);

        $this->assertEquals('ECOM', $this->request->getOrderType());
        $this->request->setOrderType('RECURRING');
        $this->assertEquals('RECURRING', $this->request->getOrderType());
        try {
            $this->request->setOrderType('INCORRECT');
        } catch (\Exception $e) {
            $this->getExpectedException();
        }
    }

    public function testSendSuccess()
    {
        $this->initRequest([
            'amount'      => '10.00',
            'currency'    => 'USD',
            'token'       => 'your-token',
            'description' => 'order-description'
        ]);

        $this->setMockHttpResponse('PurchaseSuccess.txt');

        /** @var PurchaseResponse $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        $this->assertSame('TEST_RU_1239706c-7d15-4819-89cc-b409390a63e9', $response->getToken());

        $this->assertEquals(2, $response->getAmount());
        $this->assertEquals(2, $response->getCard()->getExpiryMonth());
        $this->assertEquals(2025, $response->getCard()->getExpiryYear());
        $this->assertEquals('Example User', $response->getCard()->getName());
        $this->assertEquals(1111, $response->getCard()->getNumberLastFour());
        $this->assertEquals(2, $response->getCard()->getStartMonth());
        $this->assertEquals(2013, $response->getCard()->getStartYear());
    }

    public function testSendFail()
    {
        $this->initRequest([
            'amount'      => '10.00',
            'currency'    => 'USD',
            'token'       => 'your-token',
            'description' => 'order-description'
        ]);
        $this->setMockHttpResponse('PurchaseFail.txt');

        /** @var PurchaseResponse $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('TKN_NOT_FOUND', $response->getCode());
        $this->assertNull($response->getCard());
    }
    
    protected function initRequest(array $options)
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array_merge($options, [
            'clientKey' => 'test_client_key',
        ]));
    }
}