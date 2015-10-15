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
     * Trigger product order
     *
     * @param OrderInterface $order
     */
    public function triggerOrderCompleted(OrderInterface $order)
    {
        $this->getDispatcher()->trigger(DispatcherInterface::ON_ORDER_COMPLETED, $this, $order);
    }
}