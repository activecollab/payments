<?php

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;
use ActiveCollab\Payments\CommonOrder\CommonOrderInterface\Implementation as CommonOrderInterfaceImplementation;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;
use Carbon\Carbon;
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
        $this->reference = $reference;
        $this->timestamp = $timestamp;
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
     * Return billing period
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
     * Return next billing timestamp
     *
     * @return DateTimeValueInterface
     */
    public function getNextBillingTimestamp()
    {
        if (empty($this->next_billing_timestamp)) {
            $this->next_billing_timestamp = clone $this->getTimestamp();

            if ($this->getPeriod() == self::MONTHLY) {
                $this->next_billing_timestamp->addMonth();
            } elseif ($this->getPeriod() == self::YEARLY) {
                $this->next_billing_timestamp->addYear();
            }
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
