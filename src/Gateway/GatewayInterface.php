<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Gateway;

use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;

/**
 * @package ActiveCollab\Payments
 */
interface GatewayInterface
{
    /**
     * Return dispatcher instance.
     *
     * @return DispatcherInterface
     */
    public function &getDispatcher();

    /**
     * @param  DispatcherInterface $gateway
     * @return DispatcherInterface
     */
    public function &setDispatcher(DispatcherInterface $gateway);

    /**
     * Return gateway identifier.
     *
     * @return mixed
     */
    public function getIdentifier();

    /**
     * Return order by order ID.
     *
     * @param  string         $order_reference
     * @return OrderInterface
     */
    public function getOrderByReference($order_reference);

    /**
     * Return refund by refund ID.
     *
     * @param  string          $refund_reference
     * @return RefundInterface
     */
    public function getRefundByReference($refund_reference);

    /**
     * Return subscription by subscription ID.
     *
     * @param  string                $subscription_reference
     * @return SubscriptionInterface
     */
    public function getSubscriptionByReference($subscription_reference);
}
