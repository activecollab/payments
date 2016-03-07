<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Subscription\Rebill;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Subscription\SubscriptionEvent\Implementation as SubscriptionEventImplementation;
use ActiveCollab\Payments\Traits\Gateway;
use ActiveCollab\Payments\Traits\Timestamp;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Subscription\FailedPayment
 */
class Rebill implements RebillInterface
{
    use Gateway, Timestamp, SubscriptionEventImplementation;

    /**
     * Construct a new refund instance.
     *
     * @param string                 $subscription_reference
     * @param DateTimeValueInterface $timestamp
     * @param DateTimeValueInterface $next_billing_timestamp
     */
    public function __construct($subscription_reference, DateTimeValueInterface $timestamp, DateTimeValueInterface $next_billing_timestamp)
    {
        if (empty($subscription_reference)) {
            throw new InvalidArgumentException('Subscription # is required');
        }

        $this->subscription_reference = $subscription_reference;
        $this->timestamp = $timestamp;
        $this->next_billing_timestamp = $next_billing_timestamp;
    }

    /**
     * @var DateTimeValueInterface
     */
    private $next_billing_timestamp;

    /**
     * Return next billing timestamp.
     *
     * @return DateTimeValueInterface
     */
    public function getNextBillingTimestamp()
    {
        return $this->next_billing_timestamp;
    }
}
