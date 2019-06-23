<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Order\Refund;

use ActiveCollab\Payments\Common\GatewayedObjectInterface;
use ActiveCollab\Payments\Common\InternallyIdentifiedObjectInterface;
use ActiveCollab\Payments\Common\ReferencedObjectInterface;
use ActiveCollab\Payments\Common\TimestampedObjectInterface;
use ActiveCollab\Payments\Order\OrderInterface;

/**
 * @package ActiveCollab\Payments\Refund
 */
interface RefundInterface extends GatewayedObjectInterface, ReferencedObjectInterface, TimestampedObjectInterface, InternallyIdentifiedObjectInterface
{
    /**
     * @return string
     */
    public function getOrderReference(): string;

    /**
     * Return order by order ID.
     *
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface;

    /**
     * @return float
     */
    public function getTotal(): float;

    /**
     * @return iterable|null
     */
    public function getItems(): ?iterable;

    /**
     * Set refund items, if refund was by line item.
     *
     * @param  iterable|null   $value
     * @return RefundInterface
     */
    public function &setItems(?iterable $value): RefundInterface;

    /**
     * Return true if this refund is partial.
     *
     * @return bool
     */
    public function isPartial(): bool;
}
