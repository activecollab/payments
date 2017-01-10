<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test;

use ActiveCollab\DateValue\DateTimeValue;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\Subscription\Cancelation\CancelationInterface;
use ActiveCollab\Payments\Subscription\Change\ChangeInterface;
use ActiveCollab\Payments\Subscription\FailedPayment\FailedPaymentInterface;
use ActiveCollab\Payments\Subscription\Rebill\RebillInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\Payments\Test\Fixtures\Currency;
use ActiveCollab\Payments\Test\Fixtures\Customer;
use ActiveCollab\Payments\Test\Fixtures\ExampleOffsiteGateway;
use ActiveCollab\Payments\Test\Fixtures\Order;
use ActiveCollab\Payments\Test\Fixtures\OrderItem;
use ActiveCollab\Payments\Test\Fixtures\Subscription;

/**
 * @package ActiveCollab\Payments\Test
 */
class DispatcherTest extends TestCase
{
    /**
     * @var ExampleOffsiteGateway
     */
    protected $gateway;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var DateTimeValue
     */
    protected $timestamp;

    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * @var SubscriptionInterface
     */
    protected $subscription;

    /**
     * Set up test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new ExampleOffsiteGateway($this->dispatcher);
        $this->customer = new Customer('John Doe', 'john@example.com');
        $this->timestamp = new DateTimeValue('2015-10-15');
        $this->order = new Order($this->customer, '2015-01', $this->timestamp, 'USD', [
            new OrderItem('Expensive product', 1, 1000),
            new OrderItem('Not so expensive product', 2, 100),
        ]);

        $this->subscription = new Subscription($this->customer, '2015-01', $this->timestamp, SubscriptionInterface::BILLING_PERIOD_MONTHLY, new Currency('USD'), [
            new OrderItem('Monthly SaaS cost', 1, 25),
        ]);
    }

    /**
     * Test if order completed triggers an event.
     */
    public function testOrderCompletedTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_ORDER_COMPLETED, function (GatewayInterface $gateway, OrderInterface $order) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(OrderInterface::class, $order);

            $this->assertEquals($this->order->getReference(), $order->getReference());

            $event_triggered = true;
        });

        $this->gateway->triggerOrderCompleted($this->order);
        $this->assertTrue($event_triggered);
    }

    /**
     * Test if order refund properly triggers an event.
     */
    public function testOrderRefundedTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_ORDER_REFUNDED, function (GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(RefundInterface::class, $refund);
            $this->assertInstanceOf(OrderInterface::class, $order);

            $this->assertEquals($refund->getOrderReference(), $order->getReference());
            $this->assertEquals($refund->getTotal(), $order->getTotalAmount());

            $this->assertFalse($refund->isPartial());

            $event_triggered = true;
        });

        $this->gateway->triggerOrderRefunded($this->order, $this->timestamp);
        $this->assertTrue($event_triggered);
    }

    /**
     * Test if partial order refund properly triggers an event.
     */
    public function testOrderPartiallyRefundedTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_ORDER_PARTIALLY_REFUNDED, function (GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(RefundInterface::class, $refund);
            $this->assertInstanceOf(OrderInterface::class, $order);

            $this->assertEquals($refund->getOrderReference(), $order->getReference());
            $this->assertGreaterThan($refund->getTotal(), $order->getTotalAmount());

            $this->assertInternalType('array', $refund->getItems());
            $this->assertCount(1, $refund->getItems());
            $this->assertEquals('Expensive product', $refund->getItems()[0]->getDescription());

            $this->assertTrue($refund->isPartial());

            $event_triggered = true;
        });

        $this->gateway->triggerOrderPartiallyRefunded($this->order, [
            new OrderItem('Expensive product', 1, 1000),
        ], $this->timestamp);

        $this->assertTrue($event_triggered);
    }

    /**
     * Test if subscription created triggers an event.
     */
    public function testSubscriptionActivatedTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_SUBSCRIPTION_ACTIVATED, function (GatewayInterface $gateway, SubscriptionInterface $subscription) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(Subscription::class, $subscription);

            $this->assertEquals($this->subscription->getReference(), $subscription->getReference());

            $event_triggered = true;
        });

        $this->gateway->triggerSubscriptionActivated($this->subscription);

        $this->assertTrue($event_triggered);
    }

    /**
     * Test if subscription rebill triggers an event.
     */
    public function testSubscriptionRebillTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_SUBSCRIPTION_REBILLED, function (GatewayInterface $gateway, SubscriptionInterface $subscription, RebillInterface $rebill) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(Subscription::class, $subscription);
            $this->assertInstanceOf(RebillInterface::class, $rebill);

            $this->assertEquals($this->subscription->getReference(), $subscription->getReference());
            $this->assertEquals($this->subscription->getReference(), $rebill->getSubscriptionReference());
            $this->assertEquals($this->timestamp->addMonth()->format('Y-m-d'), $rebill->getNextBillingTimestamp()->format('Y-m-d'));

            $event_triggered = true;
        });

        $this->gateway->triggerSubscriptionRebill($this->subscription, $this->timestamp);

        $this->assertTrue($event_triggered);
    }

    /**
     * Test if subscription rebill triggers an event.
     */
    public function testSubscriptionChangeTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_SUBSCRIPTION_CHANGED, function (GatewayInterface $gateway, SubscriptionInterface $subscription, ChangeInterface $change) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(Subscription::class, $subscription);
            $this->assertInstanceOf(ChangeInterface::class, $change);

            $this->assertEquals($this->subscription->getReference(), $subscription->getReference());
            $this->assertEquals($this->subscription->getReference(), $change->getSubscriptionReference());

            $event_triggered = true;
        });

        $this->gateway->triggerSubscriptionChange($this->subscription);

        $this->assertTrue($event_triggered);
    }

    /**
     * Test if subscription cancelation triggers an event.
     */
    public function testSubscriptionCanceledTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_SUBSCRIPTION_DEACTIVATED, function (GatewayInterface $gateway, SubscriptionInterface $subscription, CancelationInterface $cancelation) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(Subscription::class, $subscription);
            $this->assertInstanceOf(CancelationInterface::class, $cancelation);

            $this->assertEquals($this->subscription->getReference(), $subscription->getReference());
            $this->assertEquals($this->subscription->getReference(), $cancelation->getSubscriptionReference());

            $event_triggered = true;
        });

        $this->gateway->triggerSubscriptionDeactivated($this->subscription);

        $this->assertTrue($event_triggered);
    }

    /**
     * Test if failed subscription payment triggers an event.
     */
    public function testFailedSubscriptionPaymentTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_SUBSCRIPTION_PAYMENT_FAILED, function (GatewayInterface $gateway, SubscriptionInterface $subscription, FailedPaymentInterface $failed_payment) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(Subscription::class, $subscription);
            $this->assertInstanceOf(FailedPaymentInterface::class, $failed_payment);

            $this->assertEquals($this->subscription->getReference(), $subscription->getReference());
            $this->assertEquals($this->subscription->getReference(), $failed_payment->getSubscriptionReference());

            $event_triggered = true;
        });

        $this->gateway->triggerSubscriptionFailedPayment($this->subscription);

        $this->assertTrue($event_triggered);
    }

    /**
     * Test if account activated manually triggers an event.
     */
    public function testSubscriptionCustomActivatedTriggersAnEvent()
    {
        $event_triggered = false;
        $note = 'some note';

        $this->dispatcher->listen(DispatcherInterface::ON_SUBSCRIPTION_CUSTOM_ACTIVATED, function (SubscriptionInterface $subscription, $note) use (&$event_triggered) {
            $this->assertInstanceOf(Subscription::class, $subscription);
            $this->assertEquals($this->subscription->getReference(), $subscription->getReference());

            $event_triggered = true;
        });

        $this->gateway->triggerSubscriptionCustomActivated($this->subscription, $note);

        $this->assertTrue($event_triggered);
    }

    /**
     * Test if subscription expired triggers an event.
     */
    public function testSubscriptionExpiredTriggersAnEvent()
    {
        $event_triggered = false;
        $note = 'some note';

        $this->dispatcher->listen(DispatcherInterface::ON_SUBSCRIPTION_EXPIRED, function (SubscriptionInterface $subscription, $note) use (&$event_triggered) {
            $this->assertInstanceOf(Subscription::class, $subscription);
            $this->assertEquals($this->subscription->getReference(), $subscription->getReference());

            $event_triggered = true;
        });

        $this->gateway->triggerSubscriptionExpired($this->subscription, $note);

        $this->assertTrue($event_triggered);
    }
}
