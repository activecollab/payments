<?php

namespace ActiveCollab\Payments\Traits;

use ActiveCollab\Payments\Gateway\GatewayInterface;

/**
 * @package ActiveCollab\Payments\Traits
 */
trait Gateway
{
    /**
     * @var GatewayInterface
     */
    private $gateway;

    /**
     * Return parent gateway
     *
     * @return GatewayInterface
     */
    public function &getGateway()
    {
        return $this->gateway;
    }

    /**
     * Set parent gateway
     *
     * @param  GatewayInterface $gateway
     * @return $this
     */
    public function &setGateway(GatewayInterface &$gateway)
    {
        $this->gateway = $gateway;

        return $this;
    }
}