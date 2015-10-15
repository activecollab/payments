<?php

namespace ActiveCollab\Payments;

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
    public function trigger($event, ...$arguments)
    {
        if (!empty($this->handlers[$event])) {
            /** @var callable $handler */
            foreach ($this->handlers[$event] as $handler) {
                call_user_func_array($handler, $arguments);
            }
        }
    }
}