<?php

namespace ActiveCollab\Payments\OrderItem;

/**
 * @package ActiveCollab\Payments\OrderItem
 */
interface OrderItemInterface
{
    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return float
     */
    public function getQuantity();

    /**
     * @return float
     */
    public function getUnitCost();
}
