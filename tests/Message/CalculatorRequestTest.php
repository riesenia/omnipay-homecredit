<?php
namespace Omnipay\HomeCredit\Message;

use Omnipay\Tests\TestCase;

class CalculatorRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new CalculatorRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'shop' => '9993',
            'secret' => 'mfrkg/ut73',
            'amount' => 11678.8,
            'lang' => 'sk',
            'test' => true
        ]);
    }

    public function testGetData()
    {
        $this->assertSame('https://i-calcsk-train.homecredit.net/icalc/entry.do', $this->request->getEndpoint());

        $data = $this->request->getData();

        $this->assertSame('11678,80', $data['o_price']);
        $this->assertSame(md5('999311678,80' . $this->request->getTimestamp() . 'mfrkg/ut73'), $data['sh']);
    }
}
