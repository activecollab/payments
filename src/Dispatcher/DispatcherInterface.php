<?php

namespace ActiveCollab\Payments\Dispatcher;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\Subscription\Cancelation\CancelationInterface;
use ActiveCollab\Payments\Subscription\Change\ChangeInterface;
use ActiveCollab\Payments\Subscription\FailedPayment\FailedPaymentInterface;
use ActiveCollab\Payments\Subscription\Rebill\RebillInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;

/**
 * @package ActiveCollab\Payments
 */
interface DispatcherInterface
{
    const ON_ORDER_COMPLETED = 'on_order_completed';
    const ON_ORDER_REFUNDED = 'on_order_refunded';
    const ON_ORDER_PARTIALLY_REFUNDED = 'on_order_partially_refunded';

    const ON_SUBSCRIPTION_ACTIVATED = 'on_subscription_activated';
    const ON_SUBSCRIPTION_REBILL= 'on_subscription_rebill';
    const ON_SUBSCRIPTION_CHANGED = 'on_subscription_changed';
    const ON_SUBSCRIPTION_PAYMENT_FAILED = 'on_subscription_payment_failed';
    const ON_SUBSCRIPTION_DEACTIVATED = 'on_subscription_deactivated';

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
     * @param \ActiveCollab\Payments\Gateway\GatewayInterface $gateway
     * @param OrderInterface   $order
     * @param \ActiveCollab\Payments\Order\Refund\RefundInterface  $refund
     */
    public function triggerOrderRefunded(GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund);

    /**
     * Trigger partial order refund event
     *
     * @param \ActiveCollab\Payments\Gateway\GatewayInterface $gateway
     * @param OrderInterface   $order
     * @param \ActiveCollab\Payments\Order\Refund\RefundInterface  $refund
     */
    public function triggerOrderPartiallyRefunded(GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund);

    /**
     * Trigger an event when subscription is changed
     *
     * @param GatewayInterface      $gateway
     * @param SubscriptionInterface $subscription
     */
    public function triggerSubscriptionActivated(GatewayInterface $gateway, SubscriptionInterface $subscription);

    /**
     * Trigger an event when gateway fails to process the payment
     *
     * @param GatewayInterface       $gateway
     * @param SubscriptionInterface  $subscription
     * @param RebillInterface        $rebill
     */
    public function triggerSubscriptionRebill(GatewayInterface $gateway, SubscriptionInterface $subscription, RebillInterface $rebill);

    /**
     * Trigger an event when subscription is changed
     *
     * @param GatewayInterface      $gateway
     * @param SubscriptionInterface $subscription
     * @param ChangeInterface       $change
     */
    public function triggerSubscriptionChanged(GatewayInterface $gateway, SubscriptionInterface $subscription, ChangeInterface $change);

    /**
     * Trigger an event when subscription is deactivated
     *
     * @param GatewayInterface      $gateway
     * @param SubscriptionInterface $subscription
     * @param CancelationInterface  $cancelation
     */
    public function triggerSubscriptionDeactivated(GatewayInterface $gateway, SubscriptionInterface $subscription, CancelationInterface $cancelation);

    /**
     * Trigger an event when gateway fails to process the payment
     *
     * @param GatewayInterface       $gateway
     * @param SubscriptionInterface  $subscription
     * @param FailedPaymentInterface $failed_payment
     */
    public function triggerSubscriptionPaymentFailed(GatewayInterface $gateway, SubscriptionInterface $subscription, FailedPaymentInterface $failed_payment);
}
