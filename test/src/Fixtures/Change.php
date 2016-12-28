<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Subscription\Change\ChangeInterface;
use ActiveCollab\Payments\Subscription\SubscriptionEvent\Implementation as SubscriptionEventImplementation;
use ActiveCollab\Payments\Common\Traits\GatewayedObject;
use ActiveCollab\Payments\Common\Traits\InternallyIdentifiedObject;
use ActiveCollab\Payments\Common\Traits\TimestampedObject;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Subscription\Change
 */
class Change implements ChangeInterface
{
    use GatewayedObject, TimestampedObject, InternallyIdentifiedObject, SubscriptionEventImplementation;

    /**
     * Construct a new refund instance.
     *
     * @param string                 $subscription_reference
     * @param DateTimeValueInterface $timestamp
     * @param GatewayInterface|null  $gateway
     */
    public function __construct($subscription_reference, DateTimeValueInterface $timestamp, GatewayInterface &$gateway = null)
    {
        if (empty($subscription_reference)) {
            throw new InvalidArgumentException('Subscription # is required');
        }

        $this->subscription_reference = $subscription_reference;
        $this->timestamp = $timestamp;
        $this->setGatewayByReference($gateway);
    }
}
