<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\Common\Traits;

use ActiveCollab\Payments\Gateway\GatewayInterface;

/**
 * @package ActiveCollab\Payments\Traits
 */
trait GatewayedObject
{
    /**
     * @var GatewayInterface
     */
    private $gateway;

    /**
     * Return parent gateway.
     *
     * @return GatewayInterface
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * Set parent gateway.
     *
     * @param  GatewayInterface $gateway
     * @return $this
     */
    protected function &setGatewayByReference(GatewayInterface &$gateway)
    {
        $this->gateway = $gateway;

        return $this;
    }
}
