<?php

namespace ActiveCollab\Payments\Subscription\Cancelation;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Traits\Gateway;
use ActiveCollab\Payments\Traits\OurIdentifier;
use ActiveCollab\Payments\Traits\Reference;
use ActiveCollab\Payments\Traits\Timestamp;
use InvalidArgumentException;
use RuntimeException;

/**
 * @package ActiveCollab\Payments\Subscription\Cancelation
 */
class Cancelation implements CancelationInterface
{
    use Gateway, Reference, Timestamp, OurIdentifier;

    /**
     * @var string
     */
    private $subscription_reference;

    /**
     * Construct a new refund instance
     *
     * @param string                 $cancelation_reference
     * @param string                 $subscription_reference
     * @param DateTimeValueInterface $timestamp
     */
    public function __construct($cancelation_reference, $subscription_reference, DateTimeValueInterface $timestamp)
    {
        if (empty($cancelation_reference)) {
            throw new InvalidArgumentException('Cancelation # is required');
        }

        if (empty($subscription_reference)) {
            throw new InvalidArgumentException('Subscription # is required');
        }

        $this->reference = $cancelation_reference;
        $this->subscription_reference = $subscription_reference;
        $this->timestamp = $timestamp;
    }

    /**
     * Return subscription reference (subscription ID)
     *
     * @return string
     */
    public function getSubscriptionReference()
    {
        return $this->subscription_reference;
    }

    /**
     * Return subscription by subscription reference
     *
     * @return SubscriptionInterface
     */
    public function getSubscription()
    {
        if ($this->gateway instanceof GatewayInterface) {
            return $this->gateway->getOrderByReference($this->getSubscriptionReference());
        }

        throw new RuntimeException('Gateway is not set');
    }
}
