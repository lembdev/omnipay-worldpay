<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay\Message;

use Mockery;
use Omnipay\Tests\TestCase;

class AbstractResponseTest extends TestCase
{
    /** @var AbstractResponse */
    protected $response;

    public function setUp()
    {
        $this->response = Mockery::mock(AbstractResponse::class)->makePartial();
    }

    public function testTransactionReference()
    {
        $testKey = 'test_key';

        $this->response->setTransactionReference($testKey);
        $this->assertSame($testKey, $this->response->getTransactionReference());
    }
}