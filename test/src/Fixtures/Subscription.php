<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Common\Traits\GatewayedObject;
use ActiveCollab\Payments\Common\Traits\InternallyIdentifiedObject;
use ActiveCollab\Payments\Common\Traits\ReferencedObject;
use ActiveCollab\Payments\Common\Traits\TimestampedObject;
use ActiveCollab\Payments\Currency\CurrencyInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface\Implementation as SubscriptionInterfaceImplementation;
use Carbon\Carbon;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Subscription
 */
class Subscription implements SubscriptionInterface
{
    use GatewayedObject, InternallyIdentifiedObject, ReferencedObject, SubscriptionInterfaceImplementation, TimestampedObject;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * Construct a new order instance.
     *
     * @param CustomerInterface      $customer
     * @param string                 $reference
     * @param DateTimeValueInterface $timestamp
     * @param string                 $period
     */
    public function __construct(CustomerInterface $customer, $reference, DateTimeValueInterface $timestamp, $period)
    {
        $this->validateCustomer($customer);
        $this->validatePeriod($period);

        $this->customer = $customer;
        $this->setReference($reference);
        $this->setTimestamp($timestamp);
        $this->period = $period;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    private $status = SubscriptionInterface::STATUS_ACTIVE;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function &setStatus(string $status): SubscriptionInterface
    {
        if (!in_array($status, SubscriptionInterface::STATUSES)) {
            throw new InvalidArgumentException('Valid status is required.');
        }

        $this->status = $status;

        return $this;
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
    public function getBillingPeriod(): string
    {
        return $this->period;
    }

    /**
     * @var DateTimeValueInterface|Carbon
     */
    private $next_billing_timestamp;

    public function getNextBillingTimestamp(): DateTimeValueInterface
    {
        if (empty($this->next_billing_timestamp)) {
            $this->next_billing_timestamp = $this->calculateNextBillingTimestamp($this->getTimestamp());
        }

        return $this->next_billing_timestamp;
    }

    /**
     * Set next billing timestamp.
     *
     * @param  DateTimeValueInterface      $value
     * @return SubscriptionInterface|$this
     */
    public function &setNextBillingTimestamp(DateTimeValueInterface $value): SubscriptionInterface
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
    public function calculateNextBillingTimestamp(DateTimeValueInterface $reference): DateTimeValueInterface
    {
        /** @var DateTimeValueInterface|Carbon $result */
        $result = clone $reference;

        if ($this->getBillingPeriod() == self::BILLING_PERIOD_MONTHLY) {
            $result->addMonth();
        } elseif ($this->getBillingPeriod() == self::BILLING_PERIOD_YEARLY) {
            $result->addYear();
        }

        return $result;
    }

    private $is_free = false;

    public function isFree(): bool
    {
        return $this->is_free;
    }

    public function &setIsFree(bool $value): SubscriptionInterface
    {
        $this->is_free = $value;

        return $this;
    }

    /**
     * Validate period value.
     *
     * @param string $value
     */
    protected function validatePeriod($value)
    {
        if (!in_array($value, self::BILLING_PERIODS)) {
            throw new InvalidArgumentException('Monthly and yearly periods are supported.');
        }
    }

    /**
     * Validate if we got a good Customer instance.
     *
     * @param CustomerInterface $value
     */
    protected function validateCustomer(CustomerInterface $value)
    {
        if (empty($value->getFullName()) || empty($value->getEmail())) {
            throw new InvalidArgumentException('Customer name and email address is expected');
        }
    }
}
