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
     * {@inheritdoc}
     */
    public function &getDispatcher(): DispatcherInterface
    {
        return $this->dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function &setDispatcher(DispatcherInterface $gateway): GatewayInterface
    {
        $this->dispatcher = $gateway;

        return $this;
    }
}
