<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValue;
use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Address\AddressInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use ActiveCollab\Payments\PaymentMethod\PaymentMethodInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use BadMethodCallException;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Test\Fixtures
 */
class ExampleOffsiteGateway implements GatewayInterface
{
    /**
     * @var OrderInterface[]
     */
    private $orders = [];

    /**
     * @var RefundInterface[]
     */
    private $refunds = [];

    /**
     * @var SubscriptionInterface[]
     */
    private $subscriptions = [];

    /**
     * @param \ActiveCollab\Payments\Dispatcher\DispatcherInterface $dispatcher
     */
    public function __construct(DispatcherInterface &$dispatcher)
    {
        $this->setDispatcherByReference($dispatcher);
    }

    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    public function getDispatcher(): DispatcherInterface
    {
        return $this->dispatcher;
    }

    protected function &setDispatcherByReference(DispatcherInterface $gateway): GatewayInterface
    {
        $this->dispatcher = $gateway;

        return $this;
    }

    public function getIdentifier(): string
    {
        return 'test';
    }

    public function getOurIdentifier(): string
    {
        return 'test';
    }

    public function addPaymentMethod(
        CustomerInterface $customer,
        ?AddressInterface $address,
        bool $set_as_default,
        ...$arguments
    ): PaymentMethodInterface
    {
        throw new BadMethodCallException('Not implemented just yet');
    }

    public function updatePaymentMethod(
        PaymentMethodInterface $payment_method,
        CustomerInterface $customer,
        ?AddressInterface $address,
        ...$arguments
    ): PaymentMethodInterface
    {
        throw new BadMethodCallException('Not implemented just yet');
    }

    public function removePaymentMethod(PaymentMethodInterface $payment_method): ?PaymentMethodInterface
    {
        throw new BadMethodCallException('Not implemented just yet');
    }

    public function getOrderByReference(string $order_reference): OrderInterface
    {
        if (isset($this->orders[$order_reference])) {
            return $this->orders[$order_reference];
        }

        throw new InvalidArgumentException("Order #{$order_reference} not found");
    }

    public function getRefundByReference(string $refund_reference): RefundInterface
    {
        if (isset($this->refunds[$refund_reference])) {
            return $this->refunds[$refund_reference];
        }

        throw new InvalidArgumentException("Refund #{$refund_reference} not found");
    }

    public function createCharge(
        CustomerInterface $customer,
        PaymentMethodInterface $payment_method,
        string $product_name,
        float $total_amount,
        float $discount_amount = null,
        float $tax_amount = null
    ): string
    {
        return '2016-02-04';
    }

    public function createSubscription(
        CustomerInterface $customer,
        PaymentMethodInterface $payment_method,
        string $product_name,
        string $period,
        ...$arguments
    ): string
    {
        return '2016-02-03';
    }

    public function updateSubscription(
        SubscriptionInterface $subscription,
        CustomerInterface $customer,
        PaymentMethodInterface $payment_method,
        string $product_name,
        string $period,
        ...$arguments
    ): void
    {
    }

    public function cancelSubscription(SubscriptionInterface $subscription, ...$arguments): void
    {
    }

    public function getSubscriptionByReference(string $subscription_reference): SubscriptionInterface
    {
        if (isset($this->subscriptions[$subscription_reference])) {
            return $this->subscriptions[$subscription_reference];
        }

        throw new InvalidArgumentException("Subscription #{$subscription_reference} not found");
    }

    public function getProductIdByNameAndBillingPeriod(
        string $product_name,
        string $period = SubscriptionInterface::BILLING_PERIOD_MONTHLY
    ): string
    {
        return '';
    }

    public function getAddOnIdByName(string $name): string
    {
        return $name;
    }

    public function getDiscountIdByName(string $name): string
    {
        return $name;
    }

    /**
     * Trigger product order completed.
     *
     * @param OrderInterface $order
     */
    public function triggerOrderCompleted(OrderInterface $order)
    {
        $this->orders[$order->getReference()] = $order;

        $this->getDispatcher()->triggerOrderCompleted($this, $order);
    }

    /**
     * Trigger order has been fully refunded.
     *
     * @param OrderInterface              $order
     * @param DateTimeValueInterface|null $timestamp
     */
    public function triggerOrderRefunded(OrderInterface $order, DateTimeValueInterface $timestamp = null)
    {
        $this->orders[$order->getReference()] = $order;

        if (empty($timestamp)) {
            $timestamp = new DateTimeValue();
        }

        $refund = new Refund(
            $order->getReference() . '-X',
            $order->getReference(),
            $timestamp,
            $order->getTotalAmount(),
            $this
        );

        $this->refunds[$refund->getReference()] = $refund;

        $this->getDispatcher()->triggerOrderRefunded($this, $order, $refund);
    }

    /**
     * Trigger order has been partially refunded.
     *
     * @param OrderInterface              $order
     * @param OrderItemInterface[]        $items
     * @param DateTimeValueInterface|null $timestamp
     */
    public function triggerOrderPartiallyRefunded(
        OrderInterface $order,
        array $items = null,
        DateTimeValueInterface $timestamp = null
    )
    {
        $this->orders[$order->getReference()] = $order;

        if (empty($timestamp)) {
            $timestamp = new DateTimeValue();
        }

        $refund = new Refund(
            $order->getReference() . '-X',
            $order->getReference(),
            $timestamp,
            200,
            $this
        );

        if (!empty($items)) {
            $refund->setItems($items);
        }

        $this->refunds[$refund->getReference()] = $refund;

        $this->getDispatcher()->triggerOrderPartiallyRefunded($this, $order, $refund);
    }

    /**
     * Trigger subscription activated (created) event.
     *
     * @param SubscriptionInterface $subscription
     */
    public function triggerSubscriptionActivated(SubscriptionInterface $subscription)
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        $this->getDispatcher()->triggerSubscriptionActivated($this, $subscription);
    }

    /**
     * Trigger subscription failed payment event.
     *
     * @param SubscriptionInterface       $subscription
     * @param DateTimeValueInterface|null $timestamp
     * @param DateTimeValueInterface|null $next_billing_timestamp
     */
    public function triggerSubscriptionRebill(
        SubscriptionInterface $subscription,
        DateTimeValueInterface $timestamp = null,
        DateTimeValueInterface $next_billing_timestamp = null
    )
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        if (empty($timestamp)) {
            $timestamp = new DateTimeValue();
        }

        if (empty($next_billing_timestamp)) {
            $next_billing_timestamp = $subscription->calculateNextBillingTimestamp($timestamp);
        }

        $rebill = new Rebill($subscription->getReference(), $timestamp, $next_billing_timestamp, $this);
        $this->getDispatcher()->triggerSubscriptionRebill($this, $subscription, $rebill);
    }

    /**
     * Trigger subscription failed payment event.
     *
     * @param SubscriptionInterface       $subscription
     * @param DateTimeValueInterface|null $timestamp
     */
    public function triggerSubscriptionChange(
        SubscriptionInterface $subscription,
        DateTimeValueInterface $timestamp = null
    )
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        if (empty($timestamp)) {
            $timestamp = new DateTimeValue();
        }

        $change = new Change($subscription->getReference(), $timestamp, $this);
        $this->getDispatcher()->triggerSubscriptionChanged($this, $subscription, $change);
    }

    /**
     * Trigger subscription deactivated (canceled) event.
     *
     * @param SubscriptionInterface       $subscription
     * @param DateTimeValueInterface|null $timestamp
     */
    public function triggerSubscriptionDeactivated(
        SubscriptionInterface $subscription,
        DateTimeValueInterface $timestamp = null
    )
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        if (empty($timestamp)) {
            $timestamp = new DateTimeValue();
        }

        $cancelation = new Cancelation($subscription->getReference(), $timestamp, $this);
        $this->getDispatcher()->triggerSubscriptionDeactivated($this, $subscription, $cancelation);
    }

    /**
     * Trigger subscription failed payment event.
     *
     * @param SubscriptionInterface       $subscription
     * @param DateTimeValueInterface|null $timestamp
     */
    public function triggerSubscriptionFailedPayment(
        SubscriptionInterface $subscription,
        DateTimeValueInterface $timestamp = null
    )
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        if (empty($timestamp)) {
            $timestamp = new DateTimeValue();
        }

        $failed_payment = new FailedPayment($subscription->getReference(), $timestamp, $this);
        $this->getDispatcher()->triggerSubscriptionPaymentFailed($this, $subscription, $failed_payment);
    }

    /**
     * Trigger account custom activated event.
     *
     * @param SubscriptionInterface $subscription
     * @param string                $note
     */
    public function triggerSubscriptionCustomActivated(SubscriptionInterface $subscription, $note)
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        $this->getDispatcher()->triggerSubscriptionCustomActivated($subscription, $note);
    }

    /**
     * Trigger subscription expired an event.
     *
     * @param SubscriptionInterface $subscription
     * @param string                $note
     */
    public function triggerSubscriptionExpired(SubscriptionInterface $subscription, $note)
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        $this->getDispatcher()->triggerSubscriptionExpired($subscription, $note);
    }

    /**
     * Execute order.
     *
     * @param  OrderInterface $order
     * @return OrderInterface
     */
    public function executeOrder(OrderInterface $order): OrderInterface
    {
        return $order;
    }

    /**
     * Return if gateway can execute order.
     *
     * @param  OrderInterface $order
     * @return bool
     */
    public function canExecuteOrder(OrderInterface $order): bool
    {
        return true;
    }
}
