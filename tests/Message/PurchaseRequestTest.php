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

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'amount'      => '10',
            'currency'    => 'USD',
            'token'       => 'your-token',
            'description' => 'order-description'
        ]);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseRequestSuccess.txt');
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        $this->assertSame('TEST_RU_1239706c-7d15-4819-89cc-b409390a63e9', $response->getToken());
        $this->assertSame('ObfuscatedCard', $response->getType());
        $this->assertSame('VISA_CREDIT', $response->getCardType());
        $this->assertSame($this->card->getName(), $response->getName());
        $this->assertSame($this->card->getExpiryMonth(), $response->getExpiryMonth());
        $this->assertSame($this->card->getExpiryYear(), $response->getExpiryYear());
        $this->assertSame('**** **** **** 1111', $response->getMaskedCardNumber());
        $this->assertSame('credit', $response->getCardClass());
        $this->assertSame('NATWEST', $response->getCardIssuer());
        $this->assertSame('CL Visa Credit Pers', $response->getCardProductTypeDescContactless());
        $this->assertSame('Visa Credit Personal', $response->getCardProductTypeDescNonContactless());
        $this->assertSame('VISA CREDIT', $response->getCardSchemeName());
        $this->assertSame('consumer', $response->getCardSchemeType());
        $this->assertSame('GB', $response->getCountryCode());
        $this->assertSame(1, $response->getIssueNumber());
        $this->assertSame(2, $response->getStartMonth());
        $this->assertSame(2013, $response->getStartYear());
        $this->assertFalse($response->getPrepaid());
        $this->assertFalse($response->getReusable());
    }
}