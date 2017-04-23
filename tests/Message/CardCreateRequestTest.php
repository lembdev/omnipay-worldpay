<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class CardCreateRequestTest extends TestCase
{
    /** @var CardCreateRequest */
    protected $request;

    /** @var CreditCard */
    protected $card;

    public function setUp()
    {
        $this->card = new CreditCard([
            'name'        => 'Example User',
            'number'      => '4111111111111111',
            'expiryMonth' => 2,
            'expiryYear'  => 2025,
            'cvv'         => 789,
        ]);

        $this->request = new CardCreateRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'clientKey' => 'test_client_key',
            'card'      => $this->card,
            'reusable'  => false
        ]);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CardCreateSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        $this->assertSame('TEST_RU_1239706c-7d15-4819-89cc-b409390a63e9', $response->getToken());
        $this->assertFalse($response->getReusable());

        $this->assertEquals($this->card->getName(), $response->getCard()->getName());
        $this->assertEquals($this->card->getNumberLastFour(), $response->getCard()->getNumberLastFour());
        $this->assertEquals($this->card->getExpiryMonth(), $response->getCard()->getExpiryMonth());
        $this->assertEquals($this->card->getExpiryYear(), $response->getCard()->getExpiryYear());
    }

    public function testSendFail()
    {
        $this->setMockHttpResponse('CardCreateFail.txt');
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        $this->assertNull($response->getCard());
        $this->assertNull($response->getReusable());
    }
}