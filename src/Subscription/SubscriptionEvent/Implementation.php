<?php

namespace ActiveCollab\Payments\Subscription\SubscriptionEvent;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use RuntimeException;

/**
 * @package ActiveCollab\Payments\Subscription\SubscriptionEvent
 */
trait Implementation
{
    /**
     * @var string
     */
    private $subscription_reference;

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
        if ($this->getGateway() instanceof GatewayInterface) {
            return $this->getGateway()->getOrderByReference($this->getSubscriptionReference());
        }

        throw new RuntimeException('Gateway is not set');
    }

    /**
     * Return parent gateway
     *
     * @return GatewayInterface
     */
    abstract public function &getGateway();
}
