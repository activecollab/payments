<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Test\Fixtures\Traits\CommonOrder;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\Payments\Common\Traits\GatewayedObject;
use Carbon\Carbon;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Subscription
 */
class Subscription implements SubscriptionInterface
{
    use GatewayedObject, CommonOrder;

    /**
     * Construct a new order instance.
     *
     * @param CustomerInterface      $customer
     * @param string                 $reference
     * @param DateTimeValueInterface $timestamp
     * @param string                 $period
     * @param string                 $currency
     * @param float                  $total
     * @param array                  $items
     */
    public function __construct(CustomerInterface $customer, $reference, DateTimeValueInterface $timestamp, $period, $currency, $total, array $items)
    {
        $this->validateCustomer($customer);
        $this->validateOrderId($reference);
        $this->validatePeriod($period);
        $this->validateCurrency($currency);
        $this->validateTotal($total);
        $this->validateItems($items);

        $this->customer = $customer;
        $this->setReference($reference);
        $this->setTimestamp($timestamp);
        $this->period = $period;
        $this->currency = $currency;
        $this->total = (float) $total;
        $this->items = $items;
    }

    /**
     * @var string
     */
    private $period;

    /**
     * Return billing period.
     *
     * @return string
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @var DateTimeValueInterface|Carbon
     */
    private $next_billing_timestamp;

    /**
     * Return next billing timestamp.
     *
     * @return DateTimeValueInterface
     */
    public function getNextBillingTimestamp()
    {
        if (empty($this->next_billing_timestamp)) {
            $this->next_billing_timestamp = $this->calculateNextBillingTimestamp($this->getTimestamp());
        }

        return $this->next_billing_timestamp;
    }

    /**
     * Set next billing timestamp.
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
     * Calculate next billing period based on reference timestamp.
     *
     * @param  DateTimeValueInterface $reference
     * @return DateTimeValueInterface
     */
    public function calculateNextBillingTimestamp(DateTimeValueInterface $reference)
    {
        /** @var DateTimeValueInterface|Carbon $result */
        $result = clone $reference;

        if ($this->getPeriod() == self::MONTHLY) {
            $result->addMonth();
        } elseif ($this->getPeriod() == self::YEARLY) {
            $result->addYear();
        }

        return $result;
    }

    /**
     * Validate period value.
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
