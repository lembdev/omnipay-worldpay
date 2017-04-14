<?php
/**
 * @author    Alexander Vyzhanov <lembdev@gmail.com>
 * @copyright 2017 Astwellsoft <astwellsoft.com>
 */

namespace lembdev\WorldPay;

use Omnipay\Tests\TestCase;

class IsoCodesTest extends TestCase
{
    protected $codes;
    protected $filePath;

    public function setUp()
    {
        $this->filePath = __DIR__ . '/../src/country_iso_code.php';
    }

    public function testFile()
    {
        $this->assertFileExists($this->filePath);
    }

    public function testFileContents()
    {
        $this->codes = require $this->filePath;

        $this->assertInternalType('array', $this->codes);
        $this->assertGreaterThan(0, count($this->codes));
    }
}