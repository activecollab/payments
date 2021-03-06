<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test\Fixtures\Traits;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use RuntimeException;

/**
 * @package ActiveCollab\Payments\Subscription\SubscriptionEvent
 */
trait SubscriptionEvent
{
    /**
     * @var string
     */
    private $subscription_reference;

    /**
     * Return subscription reference (subscription ID).
     *
     * @return string
     */
    public function getSubscriptionReference(): string
    {
        return $this->subscription_reference;
    }

    /**
     * @param  string $reference
     * @return $this
     */
    protected function &setSubscriptionReference($reference)
    {
        $this->subscription_reference = $reference;

        return $this;
    }

    /**
     * Return subscription by subscription reference.
     *
     * @return SubscriptionInterface
     */
    public function getSubscription(): SubscriptionInterface
    {
        if ($this->getGateway() instanceof GatewayInterface) {
            return $this->getGateway()->getSubscriptionByReference($this->getSubscriptionReference());
        }

        throw new RuntimeException('Gateway is not set');
    }

    /**
     * Return parent gateway.
     *
     * @return GatewayInterface
     */
    abstract public function getGateway();
}
