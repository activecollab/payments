<?php

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;
use ActiveCollab\Payments\CommonOrder\CommonOrderInterface\Implementation as CommonOrderInterfaceImplementation;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Subscription
 */
class Subscription implements SubscriptionInterface
{
    use CommonOrderInterfaceImplementation;

    /**
     * Construct a new order instance
     *
     * @param CustomerInterface      $customer
     * @param string                 $order_id
     * @param DateTimeValueInterface $timestamp
     * @param string                 $period
     * @param string                 $currency
     * @param float                  $total
     * @param array                  $items
     */
    public function __construct(CustomerInterface $customer, $order_id, DateTimeValueInterface $timestamp, $period, $currency, $total, array $items)
    {
        $this->validateCustomer($customer);
        $this->validateOrderId($order_id);
        $this->validatePeriod($period);
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

    private $next_billing_timestamp;

    /**
     * Return next billing timestamp
     *
     * @return DateTimeValueInterface
     */
    public function getNextBillingTimestamp()
    {
        if (empty($this->next_billing_timestamp)) {
            $this->next_billing_timestamp = $this->getTimestamp();
        }

        return $this->next_billing_timestamp;
    }

    /**
     * Set next billing timestamp
     *
     * @param  DateTimeValueInterface $value
     * @return $this
     */
    public function &setNextBillingTimestamp(DateTimeValueInterface $value)
    {
        $this->next_billing_timestamp = $value;

        return $this;
    }

    /**
     * Validate period value
     *
     * @param string $value
     */
    protected function validatePeriod($value)
    {
        if ($value != self::MONTHLY && $value != self::YEARLY) {
            throw new InvalidArgumentException('Monthly and yearly periods are supported');
        }
    }
}
