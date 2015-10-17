<?php

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;

/**
 * @package ActiveCollab\Payments\Subscription
 */
interface SubscriptionEventInterface
{
    /**
     * Return parent gateway
     *
     * @return GatewayInterface
     */
    public function &getGateway();

    /**
     * Set parent gateway
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
     * Return order by order ID
     *
     * @return SubscriptionInterface
     */
    public function getSubscription();

    /**
     * @return DateTimeValueInterface
     */
    public function getTimestamp();
}
