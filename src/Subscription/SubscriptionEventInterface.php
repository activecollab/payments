<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\Payments\Common\GatewayedObjectInterface;
use ActiveCollab\Payments\Common\TimestampedObjectInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;

/**
 * @package ActiveCollab\Payments\Subscription
 */
interface SubscriptionEventInterface extends GatewayedObjectInterface, TimestampedObjectInterface
{
    /**
     * Set parent gateway.
     *
     * @param  GatewayInterface $gateway
     * @return $this
     */
    public function &setGateway(GatewayInterface &$gateway);

    /**
     * @return string
     */
    public function getSubscriptionReference();

    /**
     * Return order by order ID.
     *
     * @return SubscriptionInterface
     */
    public function getSubscription();
}
