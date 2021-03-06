<?php
namespace Omnipay\HomeCredit\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * HomeCredit Calculator Response
 */
class CalculatorResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Gets the redirect target url
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->getRequest()->getEndpoint() . '?' . http_build_query($this->data);
    }

    /**
     * Get the required redirect method (either GET or POST)
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST
     *
     * @return array
     */
    public function getRedirectData()
    {
        return $this->data;
    }
}
