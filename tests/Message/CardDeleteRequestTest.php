<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class CardDeleteRequestTest extends TestCase
{
    /** @var CardCreateRequest */
    protected $request;

    /** @var CreditCard */
    protected $card;

    public function setUp()
    {
        $this->request = new CardDeleteRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'clientKey' => 'test_client_key',
            'token'     => 'token-to-delete',
        ]);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CardDeleteSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }

    public function testSendFail()
    {
        $this->setMockHttpResponse('CardDeleteFail.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('EXT_1: Token T9390a63e9 does not exist', $response->getMessage());
    }
}