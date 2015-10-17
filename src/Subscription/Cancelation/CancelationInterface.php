<?php

namespace ActiveCollab\Payments\Subscription\Cancelation;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;

/**
 * @package ActiveCollab\Payments\Subscription\Cancelation
 */
interface CancelationInterface
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
    public function getReference();

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

    /**
     * @return string
     */
    public function getOurIdentifier();

    /**
     * Set our identifier
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier($value);
}
