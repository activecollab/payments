<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

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
