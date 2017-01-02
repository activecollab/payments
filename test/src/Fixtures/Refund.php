<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Common\Traits\GatewayedObject;
use ActiveCollab\Payments\Common\Traits\InternallyIdentifiedObject;
use ActiveCollab\Payments\Common\Traits\ReferencedObject;
use ActiveCollab\Payments\Common\Traits\TimestampedObject;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use InvalidArgumentException;
use RuntimeException;

/**
 * @package ActiveCollab\Payments\Refund
 */
class Refund implements RefundInterface
{
    use GatewayedObject, ReferencedObject, TimestampedObject, InternallyIdentifiedObject;

    /**
     * @var string
     */
    private $order_reference;

    /**
     * @var float
     */
    private $total = 0.0;

    /**
     * @var OrderItemInterface[]
     */
    private $items;

    /**
     * Construct a new refund instance.
     *
     * @param string                 $refund_reference
     * @param string                 $order_reference
     * @param DateTimeValueInterface $timestamp
     * @param float                  $total
     * @param GatewayInterface|null  $gateway
     */
    public function __construct($refund_reference, $order_reference, DateTimeValueInterface $timestamp, $total, GatewayInterface &$gateway = null)
    {
        if (empty($refund_reference)) {
            throw new InvalidArgumentException('Refund # is required');
        }

        if (empty($order_reference)) {
            throw new InvalidArgumentException('Order # is required');
        }

        if ($total <= 0) {
            throw new InvalidArgumentException('Empty or credit orders are not supported');
        }

        $this->setReference($refund_reference);
        $this->order_reference = $order_reference;
        $this->setTimestamp($timestamp);
        $this->total = (float) $total;
        $this->setGatewayByReference($gateway);
    }

    /**
     * Return reference (order ID).
     *
     * @return string
     */
    public function getOrderReference()
    {
        return $this->order_reference;
    }

    /**
     * Return order by order ID.
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        if ($this->gateway instanceof GatewayInterface) {
            return $this->gateway->getOrderByReference($this->getOrderReference());
        }

        throw new RuntimeException('Gateway is not set');
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return \ActiveCollab\Payments\OrderItem\OrderItemInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set refund items, if refund was by line item.
     *
     * @param  \ActiveCollab\Payments\OrderItem\OrderItemInterface[] $value
     * @return $this
     */
    public function &setItems(array $value)
    {
        $this->items = $value;

        return $this;
    }

    /**
     * Return true if this refund is partial.
     *
     * @return bool
     */
    public function isPartial()
    {
        return $this->getTotal() < $this->getOrder()->getTotalAmount();
    }
}
