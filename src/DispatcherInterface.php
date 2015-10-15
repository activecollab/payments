<?php

namespace ActiveCollab\Payments;

/**
 * @package ActiveCollab\Payments
 */
interface DispatcherInterface
{
    const ON_ORDER_COMPLETED = 'on_order_completed';
    const ON_SUBSCRIPTION_ACTIVATED = 'on_subscription_activated';

    /**
     * Listen for a particular event
     *
     * @param string   $event
     * @param callable $handler
     */
    public function listen($event, callable $handler);

    /**
     * Trigger a particular event
     *
     * @param string $event
     * @param mixed  ...$arguments
     */
    public function trigger($event, ...$arguments);
}
