<?php
namespace Omnipay\HomeCredit\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * HomeCredit Calculator Request
 */
class CalculatorRequest extends PurchaseRequest
{
    /**
     * Endpoint type to build endpoint URL
     *
     * @var string
     */
    protected $endpointType = 'calc';

    /**
     * Get hash for request
     *
     * @return string
     */
    public function getHash()
    {
        return $this->createHash($this->getShop() . $this->getAmount() . $this->getProductSet() . $this->getTimestamp());
    }

    /**
     * Get the raw data array for the message
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('amount');

        $data = [];
        $data['shop'] = $this->getShop();
        $data['o_price'] = $this->getAmount();

        if ($this->getProductSet()) {
            $data['product_set'] = $this->getProductSet();
        }

        $data['time_request'] = $this->getTimestamp();
        $data['sh'] = $this->getHash();

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param mixed
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new CalculatorResponse($this, $data);
    }
}
