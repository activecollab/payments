<?php

namespace ActiveCollab\Payments\Test;

use ActiveCollab\Payments\DispatcherInterface;
use ActiveCollab\Payments\Dispatcher;

/**
 * @package ActiveCollab\Payments\Test
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DispatcherInterface
     */
    protected $dispatcher;

    /**
     * Set up test environment
     */
    public function setUp()
    {
        parent::setUp();

        $this->dispatcher = new Dispatcher();
    }

    /**
     * Tear down test environment
     */
    public function tearDown()
    {
        $this->dispatcher = null;

        parent::tearDown();
    }
}
