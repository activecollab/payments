<?php

namespace ActiveCollab\Payments;

/**
 * @package ActiveCollab\Payments
 */
abstract class Gateway implements GatewayInterface
{
    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * Return dispatcher instance
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