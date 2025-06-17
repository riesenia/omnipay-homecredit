<?php

declare(strict_types=1);

namespace Omnipay\HomeCredit\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\HomeCredit\Item;
use Omnipay\HomeCredit\ItemBag;

/**
 * HomeCredit Purchase Request.
 */
class PurchaseRequest extends AbstractRequest
{
    protected $_endpoints = [
        'test' => 'https://apisk-test.homecredit.sk/verdun-train/financing/v1',
        'prod' => 'https://api.homecredit.sk/financing/v1',
        'testcz' => 'https://apicz-test.homecredit.cz/verdun-train/financing/v1',
        'prodcz' => 'https://api.homecredit.cz/financing/v1'
    ];

    /** @var string[] */
    protected array $_allowedDeliveryTypes = [
        'DELIVERY_CARRIER',
        'PERSONAL_BRANCH',
        'PERSONAL_PARTNER',
        'ONLINE'
    ];

    /** @var string */
    protected string $_accessToken;

    /**
     * Setter.
     *
     * @param string $value
     *
     * @return self
     */
    public function setUsername(string $value): self
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getParameter('username');
    }

    /**
     * Setter.
     *
     * @param string $value
     *
     * @return self
     */
    public function setPassword(string $value): self
    {
        return $this->setParameter('password', $value);
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->getParameter('password');
    }

    /**
     * Set tax.
     *
     * @param float $value
     *
     * @return self
     */
    public function setTax(float $value): self
    {
        return $this->setParameter('tax', $value);
    }

    /**
     * Get tax.
     *
     * @return float
     */
    public function getTax(): float
    {
        return $this->getParameter('tax');
    }

    /**
     * Set tax rate.
     *
     * @param int $value
     *
     * @return self
     */
    public function setTaxRate(int $value): self
    {
        return $this->setParameter('taxRate', $value);
    }

    /**
     * Get tax rate.
     *
     * @return int
     */
    public function getTaxRate(): int
    {
        return $this->getParameter('taxRate');
    }

    /**
     * Set delivery type.
     *
     * @param string $value
     *
     * @return self
     */
    public function setDeliveryType(string $value): self
    {
        if (!\in_array($value, $this->_allowedDeliveryTypes)) {
            throw new \InvalidArgumentException('Unknown delivery type');
        }

        return $this->setParameter('deliveryType', $value);
    }

    /**
     * Get delivery type.
     *
     * @return string
     */
    public function getDeliveryType(): string
    {
        return $this->getParameter('deliveryType');
    }

    /**
     * Set product code.
     *
     * @param string $value
     *
     * @return self
     */
    public function setProductCode(string $value): self
    {
        return $this->setParameter('productCode', $value);
    }

    /**
     * Get product code.
     *
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->getParameter('productCode');
    }

    /**
     * Set locale.
     *
     * @param string $locale
     *
     * @return self
     */
    public function setLocale(string $locale): self
    {
        if (!\in_array($locale, ['cs_CZ', 'sk_SK'])) {
            throw new \InvalidArgumentException('Unsupported locale');
        }

        return $this->setParameter('locale', $locale);
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->getParameter('locale');
    }

    /**
     * Set test.
     *
     * @param bool $value
     *
     * @return self
     */
    public function setTest(bool $value): self
    {
        return $this->setParameter('test', $value);
    }

    /**
     * Get test.
     *
     * @return bool
     */
    public function getTest(): bool
    {
        return $this->getParameter('test');
    }

    /**
     * {@inheritdoc}
     */
    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new ItemBag($items);
        }

        return $this->setParameter('items', $items);
    }

    /**
     * Get the raw data array for the message.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('amount', 'transactionId');
        $card = $this->getCard();

        $data = [
            'customer' => [
                'firstName' => $card->getFirstName(),
                'lastName' => $card->getLastName(),
                'email' => $card->getEmail(),
                'phone' => $card->getPhone(),
                'ipAddress' => $this->getClientIp(),
                'addresses' => [
                    [
                        'name' => $card->getBillingName(),
                        'streetAddress' => $card->getBillingAddress1(),
                        'city' => $card->getBillingCity(),
                        'zip' => $card->getBillingPostcode(),
                        'addressType' => 'CONTACT'
                    ]
                ]
            ],
            'order' => [
                'number' => $this->getTransactionId(),
                'totalPrice' => [
                    'amount' => \number_format((float) $this->getAmount(), 2, '.', '') * 100,
                    'currency' => $this->getCurrency()
                ],
                'totalVat' => [
                    'number' => $this->getTax() * 100,
                    'currency' => $this->getCurrency(),
                    'vatRate' => $this->getTaxRate()
                ],
                'addresses' => [
                    [
                        'name' => $card->getBillingName(),
                        'city' => $card->getBillingCity(),
                        'streetAddress' => $card->getBillingAddress1(),
                        'zip' => $card->getBillingPostcode(),
                        'addressType' => 'BILLING'
                    ]
                ],
                'deliveryType' => $this->getDeliveryType(),
                'items' => []
            ],
            'type' => 'INSTALLMENT',
            'settingsInstallment' => [
                'productCode' => $this->getProductCode(),
            ],
            'merchantUrls' => [
                'approvedRedirect' => $this->getReturnUrl(),
                'rejectedRedirect' => $this->getReturnUrl(),
                'notificationEndpoint' => $this->getNotifyUrl()
            ]
        ];

        /** @var Item $item */
        foreach ($this->getItems() as $item) {
            $unitPrice = $item->getPrice();
            $quantity = $item->getQuantity();

            $data['order']['items'][] = [
                'code' => $item->getCode(),
                'name' => $item->getName(),
                'quantity' => $quantity,
                'totalPrice' => [
                    'amount' => ((float) \number_format($unitPrice * $quantity, 2, '.', '')) * 100,
                    'currency' => $this->getCurrency()
                ]
            ];
        }

        return $data;
    }

    /**
     * Send the request with specified data.
     *
     * @param mixed
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    public function sendData($data)
    {
        $this->_authenticate();

        try {
            $request = $this->httpClient->post($this->getEndpoint() . '/applications', [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->_accessToken
            ], \json_encode($data));
            $response = $request->send();
            $responseData = $response->json();
        } catch (\Exception $e) {
            throw new \Exception('Application request failed. Reason: ' . $e->getMessage());
        }

        return $this->response = new PurchaseResponse($this, $responseData);
    }

    /**
     * Get endpoint.
     *
     * @return string
     */
    public function getEndpoint()
    {
        $isTest = $this->getParameter('test');
        $endpoint = $this->_endpoints[$isTest ? 'test' : 'prod'];

        if ($this->getLocale() == 'cs_CZ') {
            $endpoint = $this->_endpoints[$isTest ? 'testcz' : 'prodcz'];
        }

        return $endpoint;
    }

    protected function _authenticate()
    {
        try {
            $request = $this->httpClient->post(\str_replace('/financing/v1', '/authentication/v1/partner', $this->getEndpoint()), [
                'Content-Type' => 'application/json'
            ], \json_encode([
                'username' => $this->getParameter('username'),
                'password' => $this->getParameter('password')
            ]));
            $response = $request->send();
            $responseData = $response->json();
        } catch (\Exception $e) {
            throw new \Exception('Authentication failed. Reason: ' . $e->getMessage());
        }

        if (isset($responseData['errors'])) {
            throw new \Exception('Authentication failed. Reason: ' . $responseData['errors'][0]['message']);
        }

        $this->_accessToken = $responseData['accessToken'];
    }
}
