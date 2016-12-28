<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\Order\Refund;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Common\GatewayedObjectInterface;
use ActiveCollab\Payments\Common\InternallyIdentifiedObjectInterface;
use ActiveCollab\Payments\Common\ReferencedObjectInterface;
use ActiveCollab\Payments\Common\TimestampedObjectInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use MongoDB\BSON\Timestamp;

/**
 * @package ActiveCollab\Payments\Refund
 */
interface RefundInterface extends GatewayedObjectInterface, ReferencedObjectInterface, TimestampedObjectInterface, InternallyIdentifiedObjectInterface
{
    /**
     * @return string
     */
    public function getOrderReference();

    /**
     * Return order by order ID.
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * @return float
     */
    public function getTotal();

    /**
     * @return \ActiveCollab\Payments\OrderItem\OrderItemInterface[]
     */
    public function getItems();

    /**
     * Set refund items, if refund was by line item.
     *
     * @param  \ActiveCollab\Payments\OrderItem\OrderItemInterface[] $value
     * @return $this
     */
    public function &setItems(array $value);

    /**
     * Return true if this refund is partial.
     *
     * @return bool
     */
    public function isPartial();
}
