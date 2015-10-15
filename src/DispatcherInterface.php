<?php

namespace ActiveCollab\Payments;

/**
 * @package ActiveCollab\Payments
 */
interface DispatcherInterface
{
    const ON_PRODUCT_ORDER = 'on_product_order';

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
