<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test;

use ActiveCollab\Payments\Dispatcher\Dispatcher;
use ActiveCollab\Payments\Dispatcher\DispatcherInterface;

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
     * Set up test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->dispatcher = new Dispatcher();
    }

    /**
     * Tear down test environment.
     */
    public function tearDown()
    {
        $this->dispatcher = null;

        parent::tearDown();
    }
}
