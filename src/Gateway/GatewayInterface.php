<?php

namespace ActiveCollab\Payments\Gateway;

use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;

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

    /**
     * Return gateway identifier
     *
     * @return mixed
     */
    public function getIdentifier();

    /**
     * Return order by order ID
     *
     * @param  string         $reference
     * @return OrderInterface
     */
    public function getOrderByReference($reference);

    /**
     * Return refund by refund ID
     *
     * @param  string          $refund_reference
     * @return RefundInterface
     */
    public function getRefundByReference($refund_reference);
}
