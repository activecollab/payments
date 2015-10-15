<?php

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Payments\DispatcherInterface;
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

    public function triggerProductOrder()
    {
        $this->getDispatcher()->trigger(DispatcherInterface::ON_PRODUCT_ORDER);
    }
}