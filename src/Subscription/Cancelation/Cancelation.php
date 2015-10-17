<?php

namespace ActiveCollab\Payments\Subscription\Cancelation;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;
use InvalidArgumentException;
use RuntimeException;

/**
 * @package ActiveCollab\Payments\Subscription\Cancelation
 */
class Cancelation implements CancelationInterface
{
    /**
     * @var GatewayInterface
     */
    private $gateway;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $subscription_reference;

    /**
     * @var DateTimeValueInterface
     */
    private $timestamp;

    /**
     * @var string
     */
    private $our_identifier = '';

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
     * Return parent gateway
     *
     * @return GatewayInterface
     */
    public function &getGateway()
    {
        return $this->gateway;
    }

    /**
     * Set parent gateway
     *
     * @param  GatewayInterface $gateway
     * @return $this
     */
    public function &setGateway(GatewayInterface &$gateway)
    {
        $this->gateway = $gateway;

        return $this;
    }

    /**
     * Return refund ID
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
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

    /**
     * Return date and time when this order was made
     *
     * @return DateTimeValueInterface
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Return our internal order indetifier (if present)
     *
     * @return string
     */
    public function getOurIdentifier()
    {
        return $this->our_identifier;
    }

    /**
     * Set our identifier
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier($value)
    {
        $this->our_identifier = trim($value);

        return $this;
    }
}
