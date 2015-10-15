<?php

namespace ActiveCollab\Payments;

use ActiveCollab\Payments\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Refund\RefundInterface;

/**
 * @package ActiveCollab\Payments
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    private $handlers = [];

    /**
     * Specify an event listener for a project
     *
     * @param string   $event
     * @param callable $handler
     */
    public function listen($event, callable $handler)
    {
        if (empty($this->handlers[$event])) {
            $this->handlers[$event] = [];
        }

        $this->handlers[$event][] = $handler;
    }

    /**
     * Trigger a particular event
     *
     * @param string $event
     * @param mixed  ...$arguments
     */
    protected function trigger($event, ...$arguments)
    {
        if (!empty($this->handlers[$event])) {
            /** @var callable $handler */
            foreach ($this->handlers[$event] as $handler) {
                call_user_func_array($handler, $arguments);
            }
        }
    }

    /**
     * Trigger product order completed
     *
     * @param GatewayInterface $gateway
     * @param OrderInterface   $order
     */
    public function triggerOrderCompleted(GatewayInterface $gateway, OrderInterface $order)
    {
        $this->trigger(self::ON_ORDER_COMPLETED, $gateway, $order);
    }

    /**
     * @param GatewayInterface $gateway
     * @param OrderInterface   $order
     * @param RefundInterface  $refund
     */
    public function triggerOrderRefunded(GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund)
    {
        $this->trigger(self::ON_ORDER_REFUNDED, $gateway, $order, $refund);
    }

    /**
     * @param GatewayInterface $gateway
     * @param OrderInterface   $order
     * @param RefundInterface  $refund
     */
    public function triggerOrderPartiallyRefunded(GatewayInterface $gateway, OrderInterface $order, RefundInterface $refund)
    {
        $this->trigger(self::ON_ORDER_PARTIALLY_REFUNDED, $gateway, $order, $refund);
    }
}