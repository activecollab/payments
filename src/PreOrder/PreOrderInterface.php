<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\PreOrder;

use JsonSerializable;

/**
 * @package ActiveCollab\Payments\PreOrder
 */
interface PreOrderInterface extends JsonSerializable
{
    /**
     * Return array of items in pre-order.
     *
     * @return array
     */
    public function getLineItems(): array;

    /**
     * Calculate total amount of pre-order.
     *
     * @return float
     */
    public function getTotal(): float;
}