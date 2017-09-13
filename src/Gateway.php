<?php
namespace Omnipay\HomeCredit;

use Omnipay\Common\AbstractGateway;

/**
 * Homecredit Gateway
 */
class Gateway extends AbstractGateway
{
    /**
     * Gateway name
     *
     * @return string
     */
    public function getName()
    {
        return 'HomeCredit';
    }

    /**
     * Get default parameters
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'lang' => 'sk',
            'test' => true
        ];
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setShop($value)
    {
        return $this->setParameter('shop', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getShop()
    {
        return $this->getParameter('shop');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setProductSet($value)
    {
        return $this->setParameter('product_set', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getProductSet()
    {
        return $this->getParameter('product_set');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setGName($value)
    {
        return $this->setParameter('g_name', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getGName()
    {
        return $this->getParameter('g_name');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setGProducer($value)
    {
        return $this->setParameter('g_producer', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getGProducer()
    {
        return $this->getParameter('g_producer');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setInsurance($value)
    {
        return $this->setParameter('insurance', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getInsurance()
    {
        return $this->getParameter('insurance');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setInitialPayment($value)
    {
        return $this->setParameter('initial_payment', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getInitialPayment()
    {
        return $this->getParameter('initial_payment');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setNumberPayments($value)
    {
        return $this->setParameter('number_payments', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getNumberPayments()
    {
        return $this->getParameter('number_payments');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setLang($value)
    {
        return $this->setParameter('lang', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getLang()
    {
        return $this->getParameter('lang');
    }

    /**
     * Setter
     *
     * @param string
     * @return $this
     */
    public function setTest($value)
    {
        return $this->setParameter('test', $value);
    }

    /**
     * Getter
     *
     * @return string
     */
    public function getTest()
    {
        return $this->getParameter('test');
    }

    /**
     * Create a calculator request
     *
     * @param array $parameters
     * @return \Omnipay\HomeCredit\Message\CalculatorRequest
     */
    public function calculator(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\HomeCredit\Message\CalculatorRequest', $parameters);
    }

    /**
     * Create a purchase request
     *
     * @param array $parameters
     * @return \Omnipay\HomeCredit\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\HomeCredit\Message\PurchaseRequest', $parameters);
    }

    /**
     * Create a complete purchase request
     *
     * @param array $parameters
     * @return \Omnipay\HomeCredit\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\HomeCredit\Message\CompletePurchaseRequest', $parameters);
    }
}
