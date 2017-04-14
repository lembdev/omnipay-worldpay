<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class DeleteCardRequestTest extends TestCase
{
    /** @var CreateCardRequest */
    protected $request;

    /** @var CreditCard */
    protected $card;

    public function setUp()
    {
        $this->request = new DeleteCardRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'clientKey' => 'test_client_key',
            'token'     => 'token-to-delete',
        ]);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('DeleteCardRequestSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }

    public function testSendFail()
    {
        $this->setMockHttpResponse('DeleteCardRequestFail.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }
}