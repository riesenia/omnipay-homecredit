<?php
namespace Omnipay\HomeCredit\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'shop' => '9993',
            'secret' => 'mfrkg/ut73',
            'g_name' => 'střešní krytina',
            'g_producer' => 'Balexmetal',
            'amount' => 11678.8,
            'transactionId' => '23432415',
            'returnUrl' => 'http://nasehomepage.cz',
            'card' => [
                'billingName' => 'Pavel Konečný',
                'email' => 'nas.zakaznik@nekde.cz',
                'phone' => '606123456'
            ],
            'lang' => 'sk',
            'test' => true
        ]);
    }

    public function testGetData()
    {
        $this->assertSame('https://i-shopsk-train.homecredit.net/ishop/entry.do', $this->request->getEndpoint());

        $data = $this->request->getData();

        $this->assertSame('11678,80', $data['o_price']);
        $this->assertSame(md5('99932343241511678,80PavelKonečnýstřešní krytinaBalexmetal' . $this->request->getTimestamp() . 'mfrkg/ut73'), $data['sh']);
    }
}
