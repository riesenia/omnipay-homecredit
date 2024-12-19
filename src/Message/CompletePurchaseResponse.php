<?php

declare(strict_types=1);

namespace Omnipay\HomeCredit\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * HomeCredit CompletePurchase Response.
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->data['state'] == 'READY';
    }

    /**
     * Get the transaction ID.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['id'];
    }

    /**
     * Get the transaction reference.
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->data['order']['number'];
    }
}
