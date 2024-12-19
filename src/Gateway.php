<?php

declare(strict_types=1);

namespace Omnipay\HomeCredit;

use Omnipay\Common\AbstractGateway;
use Omnipay\HomeCredit\Message\CalculatorRequest;
use Omnipay\HomeCredit\Message\CompletePurchaseRequest;
use Omnipay\HomeCredit\Message\PrescoringRequest;
use Omnipay\HomeCredit\Message\PurchaseRequest;

/**
 * Homecredit Gateway.
 */
class Gateway extends AbstractGateway
{
    /**
     * Gateway name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'HomeCredit';
    }

    /**
     * Get default parameters.
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'locale' => 'sk_SK',
            'test' => true
        ];
    }

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
     * Setter.
     *
     * @param string $value
     *
     * @return self
     */
    public function setLocale(string $value): self
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Getter.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->getParameter('locale');
    }

    /**
     * Setter.
     *
     * @param self $value
     *
     * @return self
     */
    public function setTest($value): self
    {
        return $this->setParameter('test', $value);
    }

    /**
     * Getter.
     *
     * @return bool
     */
    public function getTest(): bool
    {
        return $this->getParameter('test');
    }

    /**
     * Create a calculator request.
     *
     * @param array $parameters
     *
     * @return CalculatorRequest
     */
    public function calculator(array $parameters = []): CalculatorRequest
    {
        return $this->createRequest('\Omnipay\HomeCredit\Message\CalculatorRequest', $parameters);
    }

    /**
     * Create a prescoring request.
     *
     * @param array $parameters
     *
     * @return PrescoringRequest
     */
    public function prescoring(array $parameters = []): PrescoringRequest
    {
        return $this->createRequest('\Omnipay\HomeCredit\Message\PrescoringRequest', $parameters);
    }

    /**
     * Create a purchase request.
     *
     * @param array $parameters
     *
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = []): PurchaseRequest
    {
        return $this->createRequest('\Omnipay\HomeCredit\Message\PurchaseRequest', $parameters);
    }

    /**
     * Create a complete purchase request.
     *
     * @param array $parameters
     *
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = []): CompletePurchaseRequest
    {
        return $this->createRequest('\Omnipay\HomeCredit\Message\CompletePurchaseRequest', $parameters);
    }
}
