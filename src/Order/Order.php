<?php

namespace ActiveCollab\Payments\Order;

use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\CommonOrder\CommonOrderInterface\Implementation as CommonOrderInterfaceImplementation;
use ActiveCollab\DateValue\DateTimeValueInterface;

/**
 * @package ActiveCollab\Payments\Order
 */
class Order implements OrderInterface
{
    use CommonOrderInterfaceImplementation;

    /**
     * Construct a new order instance
     *
     * @param CustomerInterface      $customer
     * @param string                 $order_id
     * @param DateTimeValueInterface $timestamp
     * @param string                 $currency
     * @param float                  $total
     * @param array                  $items
     */
    public function __construct(CustomerInterface $customer, $order_id, DateTimeValueInterface $timestamp, $currency, $total, array $items)
    {
        $this->validateCustomer($customer);
        $this->validateOrderId($order_id);
        $this->validateCurrency($currency);
        $this->validateTotal($total);
        $this->validateItems($items);

        $this->customer = $customer;
        $this->order_id = $order_id;
        $this->timestamp = $timestamp;
        $this->currency = $currency;
        $this->total = (float) $total;
        $this->items = $items;
    }
}
