<?php

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Payments\DispatcherInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Gateway;

/**
 * @package ActiveCollab\Payments\Test\Fixtures
 */
class ExampleOffsiteGateway extends Gateway
{
    /**
     * @param DispatcherInterface $dispatcher
     */
    public function __construct(DispatcherInterface &$dispatcher)
    {
        $this->setDispatcher($dispatcher);
    }

    /**
     * Trigger product order completed
     *
     * @param OrderInterface $order
     */
    public function triggerOrderCompleted(OrderInterface $order)
    {
        $this->getDispatcher()->trigger(DispatcherInterface::ON_ORDER_COMPLETED, $this, $order);
    }

    /**
     * Trigger product order failed
     *
     * @param OrderInterface $order
     */
    public function triggerOrderFailed(OrderInterface $order)
    {
        $this->getDispatcher()->trigger(DispatcherInterface::ON_ORDER_FAILED, $this, $order);
    }

    /**
     * Trigger order has been fully refunded
     *
     * @param OrderInterface $order
     */
    public function triggerOrderRefunded(OrderInterface $order)
    {
        $this->getDispatcher()->trigger(DispatcherInterface::ON_ORDER_REFUNDED, $this, $order);
    }

    /**
     * Trigger order has been partially refunded
     *
     * @param OrderInterface $order
     */
    public function triggerOrderPartiallyRefunded(OrderInterface $order)
    {
        $this->getDispatcher()->trigger(DispatcherInterface::ON_ORDER_PARTIALLY_REFUNDED, $this, $order);
    }
}
