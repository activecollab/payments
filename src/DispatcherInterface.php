<?php

namespace ActiveCollab\Payments;

use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Refund\RefundInterface;

/**
 * @package ActiveCollab\Payments
 */
interface DispatcherInterface
{
    const ON_ORDER_COMPLETED = 'on_order_completed';
    const ON_ORDER_FAILED = 'on_order_failed';
    const ON_ORDER_REFUNDED = 'on_order_refunded';
    const ON_ORDER_PARTIALLY_REFUNDED = 'on_order_partially_refunded';

    const ON_SUBSCRIPTION_ACTIVATED = 'on_subscription_activated';

    /**
     * Listen for a particular event
     *
     * @param string   $event
     * @param callable $handler
     */
    public function listen($event, callable $handler);

    /**
     * Trigger product order completed
     *
     * @param GatewayInterface $gateway
     * @param OrderInterface   $order
     */
    public function triggerOrderCompleted(GatewayInterface $gateway, OrderInterface $order);

    /**
     * Trigger full order refund event
     *
     * @param GatewayInterface $gateway
     * @param OrderInterface   $order
     * @param RefundInterface  $refund
     */
    public function triggerOrderRefunded(GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund);

    /**
     * Trigger partial order refund event
     *
     * @param GatewayInterface $gateway
     * @param OrderInterface   $order
     * @param RefundInterface  $refund
     */
    public function triggerOrderPartiallyRefunded(GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund);
}
