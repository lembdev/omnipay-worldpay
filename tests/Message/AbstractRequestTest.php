<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Mockery;
use Omnipay\Tests\TestCase;

class AbstractRequestTest extends TestCase
{
    /** @var AbstractRequest */
    protected $request;

    public function setUp()
    {
        $this->request = Mockery::mock(AbstractRequest::class)->makePartial();
        $this->request->initialize();
    }

    public function testEndpoint()
    {
        $this->assertSame('https://api.worldpay.com/v1', $this->request->getEndpoint());
    }

    public function testClientKey()
    {
        $testKey = 'test_key';

        $this->request->setClientKey($testKey);
        $this->assertSame($testKey, $this->request->getClientKey());
    }

    public function testServiceKey()
    {
        $testKey = 'test_key';

        $this->request->setServiceKey($testKey);
        $this->assertSame($testKey, $this->request->getServiceKey());
    }
}