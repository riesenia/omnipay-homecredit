<?php

declare(strict_types=1);

namespace Omnipay\HomeCredit;

use Omnipay\Common\Item as OmnipayItem;

class Item extends OmnipayItem
{
    /**
     * Set code.
     *
     * @param string $code
     *
     * @return self
     */
    public function setCode(string $code): self
    {
        return $this->setParameter('code', $code);
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->getParameter('code');
    }
}
