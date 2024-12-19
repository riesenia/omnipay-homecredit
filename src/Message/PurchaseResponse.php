<?php

declare(strict_types=1);

namespace Omnipay\HomeCredit\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * HomeCredit Purchase Response.
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return !isset($response['errors']);
    }

    /**
     * Does the response require a redirect?
     *
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->getData()['gatewayRedirectUrl'];
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }
}
