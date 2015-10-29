<?php

namespace ActiveCollab\Payments\Subscription\Cancelation;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Subscription\SubscriptionEvent\Implementation as SubscriptionEventImplementation;
use ActiveCollab\Payments\Traits\Gateway;
use ActiveCollab\Payments\Traits\OurIdentifier;
use ActiveCollab\Payments\Traits\Timestamp;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Subscription\Cancelation
 */
class Cancelation implements CancelationInterface
{
    use Gateway, Timestamp, OurIdentifier, SubscriptionEventImplementation;

    /**
     * Construct a new refund instance
     *
     * @param string                 $subscription_reference
     * @param DateTimeValueInterface $timestamp
     */
    public function __construct($subscription_reference, DateTimeValueInterface $timestamp)
    {
        if (empty($subscription_reference)) {
            throw new InvalidArgumentException('Subscription # is required');
        }

        $this->subscription_reference = $subscription_reference;
        $this->timestamp = $timestamp;
    }
}
