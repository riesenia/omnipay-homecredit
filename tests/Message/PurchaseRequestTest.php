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
            ]
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        // hash
        $hash = md5('99932343241511678,80PavelKonečnýstřešní krytinaBalexmetal' . $this->request->getTimestamp() . 'mfrkg/ut73');

        $this->assertSame('11678,80', $data['o_price']);
        $this->assertSame($hash, $data['sh']);
    }
}
