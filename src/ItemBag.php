<?php

declare(strict_types=1);

namespace Omnipay\HomeCredit;

use Omnipay\Common\ItemBag as OmnipayItemBag;
use Omnipay\Common\ItemInterface;

class ItemBag extends OmnipayItemBag
{
    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new Item($item);
        }
    }
}
