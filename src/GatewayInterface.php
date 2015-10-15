<?php

namespace ActiveCollab\Payments;

/**
 * @package ActiveCollab\Payments
 */
interface GatewayInterface
{
    /**
     * Return dispatcher instance
     *
     * @return DispatcherInterface
     */
    public function &getDispatcher();

    /**
     * @param  DispatcherInterface $gateway
     * @return DispatcherInterface
     */
    public function &setDispatcher(DispatcherInterface $gateway);
}