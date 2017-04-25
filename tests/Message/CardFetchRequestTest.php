<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Tests\TestCase;

class CardFetchRequestTest extends TestCase
{
    /** @var CardFetchRequest */
    protected $request;

    public function setUp()
    {
        $this->request = new CardFetchRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setToken('TESTING_TOKEN');
        $this->request->setServiceKey('test_service_key');
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CardFetchSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        $this->assertEquals(2, $response->getCard()->getExpiryMonth());
        $this->assertEquals(2015, $response->getCard()->getExpiryYear());
        $this->assertEquals(1, $response->getCard()->getIssueNumber());
        $this->assertEquals('name', $response->getCard()->getName());
        $this->assertEquals(1111, $response->getCard()->getNumberLastFour());
        $this->assertEquals(2, $response->getCard()->getStartMonth());
        $this->assertEquals(2013, $response->getCard()->getStartYear());
    }

    public function testSendFail()
    {
        $this->setMockHttpResponse('CardFetchFail.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('TKN_NOT_FOUND', $response->getCode());
        $this->assertNull($response->getCard());
    }
}