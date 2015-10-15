<?php

namespace ActiveCollab\Payments\Test;

use ActiveCollab\Payments\DispatcherInterface;
use ActiveCollab\Payments\GatewayInterface;
use ActiveCollab\Payments\Test\Fixtures\ExampleOffsiteGateway;

/**
 * @package ActiveCollab\Payments\Test
 */
class DispatcherTest extends TestCase
{
    /**
     * @var GatewayInterface
     */
    protected $gateway;

    /**
     * Set up test environment
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new ExampleOffsiteGateway($this->dispatcher);
    }

    /**
     * Tear down test environment
     */
    public function tearDown()
    {
        $this->gateway = null;

        parent::tearDown();
    }

    public function testProductOrderTriggersAnEvent()
    {
        $event_triggered = false;

        $this->dispatcher->listen(DispatcherInterface::ON_PRODUCT_ORDER, function() use (&$event_triggered) {
            $event_triggered = true;
        });

        $this->gateway->triggerProductOrder();
        $this->assertTrue($event_triggered);
    }
}