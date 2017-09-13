<?php
namespace Omnipay\HomeCredit\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * HomeCredit Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Timestamp
     *
     * @var string
     */
    private $timestamp;

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
     * Validates and returns the formated amount
     *
     * @return string
     */
    public function getAmount()
    {
        return str_replace('.', ',', number_format(parent::getAmount(), 2, '.', ''));
    }

    /**
     * Get hash for request
     *
     * @return string
     */
    public function getHash()
    {
        return $this->createHash($this->getShop() . $this->getTransactionId() . $this->getAmount() . $this->getProductSet() .  $this->getCard()->getBillingFirstName() . $this->getCard()->getBillingLastName() . $this->getGName() . $this->getGProducer() . $this->getTimestamp());
    }

    /**
     * Timestamp
     *
     * @return string
     */
    public function getTimestamp()
    {
        if (!$this->timestamp) {
            $this->timestamp = gmdate('d.m.Y-H:i:s');
        }

        return $this->timestamp;
    }

    /**
     * Get the raw data array for the message
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('amount', 'transactionId');

        $data = [];
        $data['shop'] = $this->getShop();
        $data['o_code'] = $this->getTransactionId();
        $data['o_price'] = $this->getAmount();

        if ($this->getProductSet()) {
            $data['product_set'] = $this->getProductSet();
        }

        $data['c_name'] = $this->getCard()->getBillingFirstName();
        $data['c_surname'] = $this->getCard()->getBillingLastName();
        $data['c_mobile'] = $this->getCard()->getPhone();
        $data['c_email'] = $this->getCard()->getEmail();

        $data['g_name'] = $this->getGName();
        $data['g_producer'] = $this->getGProducer();

        $data['time_request'] = $this->getTimestamp();
        $data['ret_url'] = $this->getReturnUrl();
        $data['sh'] = $this->getHash();

        if ($this->getInsurance()) {
            $data['insurance'] = $this->getInsurance();
        }
        if ($this->getInitialPayment()) {
            $data['initial_payment'] = $this->getInitialPayment();
        }
        if ($this->getNumberPayments()) {
            $data['number_payments'] = $this->getNumberPayments();
        }

        return $data;
    }

    /**
     * Create hash
     *
     * @param string
     * @return string
     */
    public function createHash($string)
    {
        return md5($string . $this->getSecret());
    }

    /**
     * Send the request with specified data
     *
     * @param mixed
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    /**
     * Get endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getApplicationUrl() . '/ishop/entry.do';
    }

    /**
     * Get endpoint
     *
     * @return string
     */
    public function getApplicationUrl()
    {
        if ($this->getLang() == 'sk') {
            return $this->getTest() ? 'https://i-shopsk-train.homecredit.net' : 'https://i-shopsk.homecredit.net';
        }

        if ($this->getLang() == 'cz') {
            return $this->getTest() ? 'https://i-shop-train.homecredit.net' : 'https://i-shop.homecredit.cz';
        }

        throw new \UnexpectedValueException('Unexpected language!');
    }
}
