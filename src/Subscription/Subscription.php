<?php

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;
use ActiveCollab\Payments\CommonOrder\CommonOrderInterface\Implementation as CommonOrderInterfaceImplementation;
use ActiveCollab\Payments\Customer\CustomerInterface;
use DateTime;

/**
 * @package ActiveCollab\Payments\Subscription
 */
class Subscription implements SubscriptionInterface
{
    use CommonOrderInterfaceImplementation;

    /**
     * Construct a new order instance
     *
     * @param CustomerInterface $customer
     * @param string            $order_id
     * @param DateTime          $timestamp
     * @param string            $currency
     * @param float             $total
     * @param array             $items
     */
    public function __construct(CustomerInterface $customer, $order_id, DateTime $timestamp, $currency, $total, array $items)
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

    /**
     * Return subscription beginning timestamp
     *
     * @return \DateTime
     */
    public function getBeginTimestamp()
    {

    }

    /**
     * Return subscription end timestamp
     *
     * @return \DateTime
     */
    public function getEndTimestamp()
    {

    }

    /**
     * Return next billing timestamp
     *
     * @return \DateTime
     */
    public function getNextBillingTimestamp()
    {

    }
}
