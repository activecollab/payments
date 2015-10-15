<?php

namespace ActiveCollab\Payments;

use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Refund\RefundInterface;

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
     * Return order by order ID
     *
     * @param  string         $order_id
     * @return OrderInterface
     */
    public function getOrderById($order_id);

    /**
     * Return refund by refund ID
     *
     * @param  string          $refund_id
     * @return RefundInterface
     */
    public function getRefundByid($refund_id);
}