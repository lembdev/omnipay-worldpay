<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class CreateCardRequestTest extends TestCase
{
    /** @var CreateCardRequest */
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

        $this->request = new CreateCardRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'clientKey' => 'test_client_key',
            'card'      => $this->card,
            'reusable'  => false
        ]);
    }

    public function testGetData()
    {
        $card = $this->card;
        $data = $this->request->getData();

        $this->assertSame($card->getNumber(), $data['paymentMethod']['cardNumber']);
        $this->assertSame($card->getExpiryMonth(), $data['paymentMethod']['expiryMonth']);
        $this->assertSame($card->getExpiryYear(), $data['paymentMethod']['expiryYear']);
        $this->assertSame($card->getName(), $data['paymentMethod']['name']);
        $this->assertSame($card->getCvv(), $data['paymentMethod']['cvc']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CreateCardRequestSuccess.txt');
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