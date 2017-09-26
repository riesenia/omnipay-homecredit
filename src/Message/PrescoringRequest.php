<?php
namespace Omnipay\HomeCredit\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * HomeCredit Prescoring Request
 */
class PrescoringRequest extends PurchaseRequest
{
    /**
     * Get hash for request
     *
     * @return string
     */
    public function getHash()
    {
        return $this->createHash($this->getShop() . $this->getTimestamp() . $this->getReturnUrl());
    }

    /**
     * Get the raw data array for the message
     *
     * @return mixed
     */
    public function getData()
    {
        $data = [];
        $data['shop'] = $this->getShop();
        $data['time_request'] = $this->getTimestamp();
        $data['ret_url'] = $this->getReturnUrl();
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
        return $this->response = new PrescoringResponse($this, $data);
    }

    /**
     * Get endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getApplicationUrl() . '/i' . $this->endpointType . '/prescoring';
    }
}
