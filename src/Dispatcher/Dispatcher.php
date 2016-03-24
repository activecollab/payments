<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\Dispatcher;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\Subscription\Cancelation\CancelationInterface;
use ActiveCollab\Payments\Subscription\Change\ChangeInterface;
use ActiveCollab\Payments\Subscription\FailedPayment\FailedPaymentInterface;
use ActiveCollab\Payments\Subscription\Rebill\RebillInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use LogicException;

/**
 * @package ActiveCollab\Payments
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    private $handlers = [];

    /**
     * Specify an event listener for a project.
     *
     * @param string   $event
     * @param callable $handler
     */
    public function listen($event, callable $handler)
    {
        if (empty($this->handlers[$event])) {
            $this->handlers[$event] = [];
        }

        $this->handlers[$event][] = $handler;
    }

    /**
     * Trigger a particular event.
     *
     * @param string $event
     * @param mixed  ...$arguments
     */
    protected function trigger($event, ...$arguments)
    {
        if (!empty($this->handlers[$event])) {
            /** @var callable $handler */
            foreach ($this->handlers[$event] as $handler) {
                call_user_func_array($handler, $arguments);
            }
        }
    }

    /**
     * Trigger product order completed.
     *
     * @param \ActiveCollab\Payments\Gateway\GatewayInterface $gateway
     * @param OrderInterface                                  $order
     */
    public function triggerOrderCompleted(GatewayInterface $gateway, OrderInterface $order)
    {
        $this->trigger(self::ON_ORDER_COMPLETED, $gateway, $order);
    }

    /**
     * @param GatewayInterface $gateway
     * @param OrderInterface   $order
     * @param RefundInterface  $refund
     */
    public function triggerOrderRefunded(GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund)
    {
        if ($order->getTotal() != $refund->getTotal()) {
            throw new LogicException('Refunds needs to be full');
        }

        $this->trigger(self::ON_ORDER_REFUNDED, $gateway, $order, $refund);
    }

    /**
     * @param \ActiveCollab\Payments\Gateway\GatewayInterface     $gateway
     * @param OrderInterface                                      $order
     * @param \ActiveCollab\Payments\Order\Refund\RefundInterface $refund
     */
    public function triggerOrderPartiallyRefunded(GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund)
    {
        if ($order->getTotal() <= $refund->getTotal()) {
            throw new LogicException("Refunded amount needs to be less than order's total amount");
        }

        $this->trigger(self::ON_ORDER_PARTIALLY_REFUNDED, $gateway, $order, $refund);
    }

    /**
     * Trigger an event when subscription is changed.
     *
     * @param GatewayInterface      $gateway
     * @param SubscriptionInterface $subscription
     */
    public function triggerSubscriptionActivated(GatewayInterface $gateway, SubscriptionInterface $subscription)
    {
        $this->trigger(self::ON_SUBSCRIPTION_ACTIVATED, $gateway, $subscription);
    }

    /**
     * Trigger an event when gateway fails to process the payment.
     *
     * @param GatewayInterface      $gateway
     * @param SubscriptionInterface $subscription
     * @param RebillInterface       $rebill
     */
    public function triggerSubscriptionRebill(GatewayInterface $gateway, SubscriptionInterface $subscription, RebillInterface $rebill)
    {
        $this->trigger(self::ON_SUBSCRIPTION_REBILLED, $gateway, $subscription, $rebill);
    }

    /**
     * Trigger an event when subscription is changed.
     *
     * @param GatewayInterface      $gateway
     * @param SubscriptionInterface $subscription
     * @param ChangeInterface       $change
     */
    public function triggerSubscriptionChanged(GatewayInterface $gateway, SubscriptionInterface $subscription, ChangeInterface $change)
    {
        $this->trigger(self::ON_SUBSCRIPTION_CHANGED, $gateway, $subscription, $change);
    }

    /**
     * Trigger an event when subscription is deactivated.
     *
     * @param GatewayInterface      $gateway
     * @param SubscriptionInterface $subscription
     * @param CancelationInterface  $cancelation
     */
    public function triggerSubscriptionDeactivated(GatewayInterface $gateway, SubscriptionInterface $subscription, CancelationInterface $cancelation)
    {
        $this->trigger(self::ON_SUBSCRIPTION_DEACTIVATED, $gateway, $subscription, $cancelation);
    }

    /**
     * Trigger an event when gateway fails to process the payment.
     *
     * @param GatewayInterface       $gateway
     * @param SubscriptionInterface  $subscription
     * @param FailedPaymentInterface $failed_payment
     */
    public function triggerSubscriptionPaymentFailed(GatewayInterface $gateway, SubscriptionInterface $subscription, FailedPaymentInterface $failed_payment)
    {
        $this->trigger(self::ON_SUBSCRIPTION_PAYMENT_FAILED, $gateway, $subscription, $failed_payment);
    }
}
