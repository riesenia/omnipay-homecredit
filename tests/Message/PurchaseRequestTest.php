<?php

declare(strict_types=1);

namespace Omnipay\HomeCredit\Message;

use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * Test input data.
     */
    public function testGetData()
    {
        $this->assertSame('https://apisk-test.homecredit.sk/verdun-train/financing/v1', $this->request->getEndpoint());

        $data = $this->request->getData();

        $this->assertSame((float) 3390, $data['order']['totalPrice']['amount']);
    }

    /**
     * Set up method.
     */
    public function setUp()
    {
        $gateway = Omnipay::create('HomeCredit');
        $gateway->initialize([
            'username' => 'test',
            'password' => 'test',
            'locale' => 'sk_SK',
            'test' => true
        ]);

        $this->request = $gateway->purchase([
            'amount' => 33.9,
            'tax' => 5.65,
            'taxRate' => 20,
            'deliveryType' => 'DELIVERY_CARRIER',
            'transactionId' => '23432415',
            'returnUrl' => 'http://nasehomepage.cz',
            'card' => [
                'billingName' => 'Pavel Konečný',
                'email' => 'nas.zakaznik@nekde.cz',
                'phone' => '606123456'
            ],
            'items' => [
                [
                    'name' => 'Testovací položka',
                    'code' => 12345,
                    'quantity' => 1,
                    'price' => 33.9
                ]
            ]
        ]);
    }
}
