<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValue;
use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\DateValue\DateValueInterface;
use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use ActiveCollab\Payments\PaymentMethod\PaymentMethodInterface;
use ActiveCollab\Payments\PreOrder\PreOrderInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
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

    /**
     * {@inheritdoc}
     */
    public function getDispatcher(): DispatcherInterface
    {
        return $this->dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    protected function &setDispatcherByReference(DispatcherInterface $gateway): GatewayInterface
    {
        $this->dispatcher = $gateway;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier(): string
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function getOurReference(): string
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultPaymentMethod(string $customer_id)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function listPaymentMethods(string $customer_id): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function addPaymentMethod(CustomerInterface $customer, bool $set_as_default, ...$arguments): PaymentMethodInterface
    {
        throw new \BadMethodCallException('Not implemented just yet');
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderByReference(string $order_reference): OrderInterface
    {
        if (isset($this->orders[$order_reference])) {
            return $this->orders[$order_reference];
        }

        throw new InvalidArgumentException("Order #{$order_reference} not found");
    }

    /**
     * {@inheritdoc}
     */
    public function getRefundByReference(string $refund_reference): RefundInterface
    {
        if (isset($this->refunds[$refund_reference])) {
            return $this->refunds[$refund_reference];
        }

        throw new InvalidArgumentException("Refund #{$refund_reference} not found");
    }

    /**
     * {@inheritdoc}
     */
    public function createSubscription(CustomerInterface $customer, PaymentMethodInterface $payment_method, $product_name, string $period, ...$arguments): SubscriptionInterface
    {
        return new Subscription($customer, '2016-02-03', new DateTimeValue(), $period, 'USD', 200, []);
    }

    /**
     * {@inheritdoc}
     */
    public function updateSubscription(SubscriptionInterface $subscription, CustomerInterface $customer, PaymentMethodInterface $payment_method, $product_name, string $period, ...$arguments): SubscriptionInterface
    {
        return $subscription;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscriptionByReference(string $subscription_reference): SubscriptionInterface
    {
        if (isset($this->subscriptions[$subscription_reference])) {
            return $this->subscriptions[$subscription_reference];
        }

        throw new InvalidArgumentException("Subscription #{$subscription_reference} not found");
    }

    /**
     * {@inheritdoc}
     */
    public function getProductIdByNameAndBillingPeriod(string $product_name, string $period = SubscriptionInterface::MONTHLY): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getAddOnIdByName(string $name): string
    {
        return $name;
    }

    /**
     * {@inheritdoc}
     */
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

        $refund = new Refund($order->getReference() . '-X', $order->getReference(), $timestamp, $order->getTotal(), $this);

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
    public function triggerOrderPartiallyRefunded(OrderInterface $order, array $items = null, DateTimeValueInterface $timestamp = null)
    {
        $this->orders[$order->getReference()] = $order;

        if (empty($timestamp)) {
            $timestamp = new DateTimeValue();
        }

        $refund = new Refund($order->getReference() . '-X', $order->getReference(), $timestamp, 200, $this);

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
    public function triggerSubscriptionRebill(SubscriptionInterface $subscription, DateTimeValueInterface $timestamp = null, DateTimeValueInterface $next_billing_timestamp = null)
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
    public function triggerSubscriptionChange(SubscriptionInterface $subscription, DateTimeValueInterface $timestamp = null)
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
    public function triggerSubscriptionDeactivated(SubscriptionInterface $subscription, DateTimeValueInterface $timestamp = null)
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
    public function triggerSubscriptionFailedPayment(SubscriptionInterface $subscription, DateTimeValueInterface $timestamp = null)
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
     * Execute pre-order.
     *
     * @param  PreOrderInterface      $pre_order
     * @param  PaymentMethodInterface $payment_method
     * @param  string                 $action
     * @param  DateValueInterface     $first_billing_date
     * @return CommonOrderInterface
     */
    public function executePreOrder(PreOrderInterface $pre_order, PaymentMethodInterface $payment_method, string $action, DateValueInterface $first_billing_date = null): CommonOrderInterface
    {
        return new Subscription(
            new Customer('Test', 'test@example.com', false),
            '2016-02-03',
            new DateTimeValue(),
            SubscriptionInterface::MONTHLY,
            'USD',
            200,
            []
        );
    }

    /**
     * Return if gateway can execute pre-order.
     *
     * @param  PreOrderInterface $pre_order
     * @return bool
     */
    public function canExecutePreOrder(PreOrderInterface $pre_order): bool
    {
        return true;
    }
}
