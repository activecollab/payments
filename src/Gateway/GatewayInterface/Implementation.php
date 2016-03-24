<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Gateway\GatewayInterface;

use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;

/**
 * @package ActiveCollab\Payments\Gateway\GatewayInterface
 */
trait Implementation
{
    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * Return dispatcher instance.
     *
     * @return DispatcherInterface
     */
    public function &getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param  DispatcherInterface $gateway
     * @return DispatcherInterface
     */
    public function &setDispatcher(DispatcherInterface $gateway)
    {
        $this->dispatcher = $gateway;

        return $this;
    }
}
