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
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
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
     * @param \ActiveCollab\Payments\Dispatcher\DispatcherInterface $dispatcher
     */
    public function __construct(DispatcherInterface &$dispatcher)
    {
        $this->setDispatcher($dispatcher);
    }

    /**
     * Return order by order ID
     *
     * @param  string         $reference
     * @return OrderInterface
     */
    public function getByOrderReference($reference)
    {
        if (isset($this->orders[$reference])) {
            return $this->orders[$reference];
        }

        throw new InvalidArgumentException("Order #{$reference} not found");
    }

    /**
     * Return refund by refund ID
     *
     * @param  string          $refund_id
     * @return RefundInterface
     */
    public function getRefundByid($refund_id)
    {
        if (isset($this->refunds[$refund_id])) {
            return $this->refunds[$refund_id];
        }

        throw new InvalidArgumentException("Refund #{$refund_id} not found");
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

        $this->refunds[$refund->getRefundId()] = $refund;

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

        $this->refunds[$refund->getRefundId()] = $refund;

        $this->getDispatcher()->triggerOrderPartiallyRefunded($this, $order, $refund);
    }

    public function triggerSubscriptionActivated(SubscriptionInterface $subscription)
    {
        $this->subscriptions[$subscription->getReference()] = $subscription;

        $this->getDispatcher()->triggerSubscriptionActivated($this, $subscription);
    }
}
