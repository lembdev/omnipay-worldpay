<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Common\CreditCard;
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

    public function testSendTokenSuccess()
    {
        $this->initRequest([
            'amount'      => '10.00',
            'currency'    => 'USD',
            'token'       => 'your-token',
            'description' => 'order-description'
        ]);

        $this->setMockHttpResponse('PurchaseSuccessToken.txt');

        /** @var PurchaseResponse $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('TEST_RU_1239706c-7d15-4819-89cc-b409390a63e9', $response->getToken());
        $this->assertEquals(500, $response->getAmount());
        $this->assertEquals(2, $response->getCard()->getExpiryMonth());
        $this->assertEquals(2015, $response->getCard()->getExpiryYear());
        $this->assertEquals('Example User', $response->getCard()->getName());
        $this->assertEquals(1111, $response->getCard()->getNumberLastFour());
    }

    public function testSendCardSuccess()
    {
        $creditCard = new CreditCard(array(
            'name'        => 'EXAMPLE CUSTOMER',
            'number'      => '4444 3333 2222 1111',
            'expiryMonth' => 2,
            'expiryYear'  => 2025,
            'cvv'         => '123',
        ));

        $this->initRequest([
            'amount'        => '10.00',
            'currency'      => 'USD',
            'description'   => 'order-description',
            'card'          => $creditCard
        ]);

        $this->setMockHttpResponse('PurchaseSuccessCard.txt');

        /** @var PurchaseResponse $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('TEST_RU_1239706c-7d15-4819-89cc-b409390a63e9', $response->getToken());
        $this->assertEquals(500, $response->getAmount());
        $this->assertEquals(2, $response->getCard()->getExpiryMonth());
        $this->assertEquals(2020, $response->getCard()->getExpiryYear());
        $this->assertEquals('Example User', $response->getCard()->getName());
        $this->assertEquals(1111, $response->getCard()->getNumberLastFour());
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
        $_SERVER['REMOTE_ADDR'] = '254.254.254.254';
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($options);
        $this->request->setServiceKey('test_service_key');
    }
}