<?php

namespace ActiveCollab\Payments\Test;

use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Customer\Customer;
use ActiveCollab\Payments\DispatcherInterface;
use ActiveCollab\Payments\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Order;
use ActiveCollab\Payments\OrderItem\OrderItem;
use ActiveCollab\Payments\Refund\RefundInterface;
use ActiveCollab\Payments\Test\Fixtures\ExampleOffsiteGateway;
use DateTime;
use DateTimeZone;

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
     * @var DateTime
     */
    protected $timestamp;

    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * Set up test environment
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new ExampleOffsiteGateway($this->dispatcher);
        $this->customer = new Customer('John Doe', 'john@example.com');
        $this->timestamp = new DateTime('2015-10-15', new DateTimeZone('UTC'));
        $this->order = new Order($this->customer, '2015-01', $this->timestamp, 'USD', 1200, [
            new OrderItem('Expensive product', 1, 1000),
            new OrderItem('Not so expensive product', 2, 100),
        ]);
    }

    /**
     * Tear down test environment
     */
    public function tearDown()
    {
        $this->gateway = null;

        parent::tearDown();
    }

    /**
     * Test if order completed triggers an event
     */
    public function testOrderCompletedTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_ORDER_COMPLETED, function($gateway, $order) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(OrderInterface::class, $order);

            $event_triggered = true;
        });

        $this->gateway->triggerOrderCompleted($this->order);
        $this->assertTrue($event_triggered);
    }

    /**
     * Test if order refund properly triggers an event
     */
    public function testOrderRefundedTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_ORDER_REFUNDED, function(GatewayInterface $gateway, RefundInterface $refund, OrderInterface $order) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(RefundInterface::class, $refund);
            $this->assertInstanceOf(OrderInterface::class, $order);

            $this->assertEquals($refund->getOrderId(), $order->getOrderId());
            $this->assertEquals($refund->getTotal(), $order->getTotal());

            $this->assertFalse($refund->isPartial());

            $event_triggered = true;
        });

        $this->gateway->triggerOrderRefunded($this->order, $this->timestamp);
        $this->assertTrue($event_triggered);
    }

    /**
     * Test if partial order refund properly triggers an event
     */
    public function testOrderPartiallyRefundedTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_ORDER_PARTIALLY_REFUNDED, function(GatewayInterface $gateway, RefundInterface $refund, OrderInterface $order) use (&$event_triggered) {
            $this->assertInstanceOf(ExampleOffsiteGateway::class, $gateway);
            $this->assertInstanceOf(RefundInterface::class, $refund);
            $this->assertInstanceOf(OrderInterface::class, $order);

            $this->assertEquals($refund->getOrderId(), $order->getOrderId());
            $this->assertGreaterThan($refund->getTotal(), $order->getTotal());

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
}