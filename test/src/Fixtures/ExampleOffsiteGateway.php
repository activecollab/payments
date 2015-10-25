<?php

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValue;
use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Gateway\Gateway;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\Order\Refund\Refund;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Subscription\Cancelation\Cancelation;
use ActiveCollab\Payments\Subscription\Change\Change;
use ActiveCollab\Payments\Subscription\FailedPayment\FailedPayment;
use ActiveCollab\Payments\Subscription\Rebill\Rebill;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\Payments\Subscription\Cancelation\CancelationInterface;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Test\Fixtures
 */
class ExampleOffsiteGateway extends Gateway
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
     * @var CancelationInterface[]
     */
    private $cancelations = [];

    /**
     * @param \ActiveCollab\Payments\Dispatcher\DispatcherInterface $dispatcher
     */
    public function __construct(DispatcherInterface &$dispatcher)
    {
        $this->setDispatcher($dispatcher);
    }

    /**
     * Return gateway identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'test';
    }

    /**
     * Return order by order ID
     *
     * @param  string         $reference
     * @return OrderInterface
     */
    public function getOrderByReference($reference)
    {
        if (isset($this->orders[$reference])) {
            return $this->orders[$reference];
        }

        throw new InvalidArgumentException("Order #{$reference} not found");
    }

    /**
     * Return refund by refund ID
     *
     * @param  string          $refund_reference
     * @return RefundInterface
     */
    public function getRefundByReference($refund_reference)
    {
        if (isset($this->refunds[$refund_reference])) {
            return $this->refunds[$refund_reference];
        }

        throw new InvalidArgumentException("Refund #{$refund_reference} not found");
    }

    /**
     * Trigger product order completed
     *
     * @param OrderInterface $order
     */
    public function triggerOrderCompleted(OrderInterface $order)
    {
        $this->orders[$order->getReference()] = $order;

        $this->getDispatcher()->triggerOrderCompleted($this, $order);
    }

    /**
     * Trigger order has been fully refunded
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

        $refund = new Refund($order->getReference() . '-X', $order->getReference(), $timestamp, $order->getTotal());
        $refund->setGateway($this);

        $this->refunds[$refund->getReference()] = $refund;

        $this->getDispatcher()->triggerOrderRefunded($this, $order, $refund);
    }

    /**
     * Trigger order has been partially refunded
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

        $refund = new Refund($order->getReference() . '-X', $order->getReference(), $timestamp, 200);
        $refund->setGateway($this);

        if (!empty($items)) {
            $refund->setItems($items);
        }

        $this->refunds[$refund->getReference()] = $refund;

        $this->getDispatcher()->triggerOrderPartiallyRefunded($this, $order, $refund);
    }

    /**
     * Trigger subscription activated (created) event
     *
     * @param SubscriptionInterface $subscription
     */
    public function triggerSubscriptionActivated(SubscriptionInterface $subscription)
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        $this->getDispatcher()->triggerSubscriptionActivated($this, $subscription);
    }

    /**
     * Trigger subscription failed payment event
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

        $rebill = new Rebill($subscription->getReference(), $timestamp, $next_billing_timestamp);
        $rebill->setGateway($this);

        $this->getDispatcher()->triggerSubscriptionRebill($this, $subscription, $rebill);
    }

    /**
     * Trigger subscription failed payment event
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

        $change = new Change($subscription->getReference(), $timestamp);
        $change->setGateway($this);

        $this->getDispatcher()->triggerSubscriptionChanged($this, $subscription, $change);
    }

    /**
     * Trigger subscription deactivated (canceled) event
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

        $cancelation = new Cancelation($subscription->getReference() . '-X', $subscription->getReference(), $timestamp);
        $cancelation->setGateway($this);

        $this->cancelations[$cancelation->getReference()] = $cancelation;

        $this->getDispatcher()->triggerSubscriptionDeactivated($this, $subscription, $cancelation);
    }

    /**
     * Trigger subscription failed payment event
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

        $failed_payment = new FailedPayment($subscription->getReference(), $timestamp);
        $failed_payment->setGateway($this);

        $this->getDispatcher()->triggerSubscriptionPaymentFailed($this, $subscription, $failed_payment);
    }
}
