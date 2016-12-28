<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Subscription\Rebill;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Common\Traits\GatewayedObject;
use ActiveCollab\Payments\Common\Traits\TimestampedObject;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Subscription\SubscriptionEvent\Implementation as SubscriptionEventImplementation;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Subscription\FailedPayment
 */
class Rebill implements RebillInterface
{
    use GatewayedObject, TimestampedObject, SubscriptionEventImplementation;

    /**
     * Construct a new refund instance.
     *
     * @param string                 $subscription_reference
     * @param DateTimeValueInterface $timestamp
     * @param DateTimeValueInterface $next_billing_timestamp
     * @param GatewayInterface|null  $gateway
     */
    public function __construct($subscription_reference, DateTimeValueInterface $timestamp, DateTimeValueInterface $next_billing_timestamp, GatewayInterface &$gateway = null)
    {
        if (empty($subscription_reference)) {
            throw new InvalidArgumentException('Subscription # is required');
        }

        $this->subscription_reference = $subscription_reference;
        $this->timestamp = $timestamp;
        $this->next_billing_timestamp = $next_billing_timestamp;
        $this->setGatewayByReference($gateway);
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
