<?php
namespace Omnipay\HomeCredit\Message;

use Omnipay\Tests\TestCase;

class PrescoringRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new PrescoringRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'shop' => '9993',
            'secret' => 'mfrkg/ut73',
            'returnUrl' => 'http://nasehomepage.cz',
            'lang' => 'sk',
            'test' => true
        ]);
    }

    public function testGetData()
    {
        $this->assertSame('https://i-shopsk-train.homecredit.net/ishop/prescoring', $this->request->getEndpoint());

        $data = $this->request->getData();

        $this->assertSame(md5('9993' . $this->request->getTimestamp() . 'http://nasehomepage.czmfrkg/ut73'), $data['sh']);
    }
}
