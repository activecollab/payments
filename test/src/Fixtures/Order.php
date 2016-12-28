<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Test\Fixtures\Traits\CommonOrder;

/**
 * @package ActiveCollab\Payments\Order
 */
class Order implements OrderInterface
{
    use CommonOrder;

    /**
     * Construct a new order instance.
     *
     * @param CustomerInterface      $customer
     * @param string                 $reference
     * @param DateTimeValueInterface $timestamp
     * @param string                 $currency
     * @param float                  $total
     * @param array                  $items
     */
    public function __construct(CustomerInterface $customer, $reference, DateTimeValueInterface $timestamp, $currency, $total, array $items)
    {
        $this->validateCustomer($customer);
        $this->validateOrderId($reference);
        $this->validateCurrency($currency);
        $this->validateTotal($total);
        $this->validateItems($items);

        $this->customer = $customer;
        $this->reference = $reference;
        $this->setTimestamp($timestamp);
        $this->currency = $currency;
        $this->total = (float) $total;
        $this->items = $items;
    }
}
