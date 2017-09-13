<?php
namespace Omnipay\HomeCredit\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * HomeCredit CompletePurchase Response
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return isset($this->data['hc_ret']) && $this->data['hc_ret'] == 'Y';
    }

    /**
     * Get the transaction ID
     *
     * @return string
     */
    public function getTransactionId()
    {
        return isset($this->data['hc_o_code']) ? $this->data['hc_o_code'] : null;
    }

    /**
     * Get the transaction reference
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return isset($this->data['hc_o_code']) ? $this->data['hc_o_code'] : null;
    }

    /**
     * Response Message
     *
     * @return null|string
     */
    public function getMessage()
    {
        return isset($this->data['hc_ret']) ? $this->data['hc_ret'] : null;
    }
}
