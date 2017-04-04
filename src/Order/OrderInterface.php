<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Order;

use ActiveCollab\Object\ObjectInterface;
use ActiveCollab\Payments\Common\InternallyIdentifiedObjectInterface;
use ActiveCollab\Payments\Common\ReferencedObjectInterface;
use ActiveCollab\Payments\Common\TimestampedObjectInterface;
use ActiveCollab\Payments\Currency\CurrencyInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Order\Calculator\CalculationInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;

/**
 * @package ActiveCollab\Payments\Order
 */
interface OrderInterface extends
    ReferencedObjectInterface,
    InternallyIdentifiedObjectInterface,
    ObjectInterface,
    TimestampedObjectInterface
{
    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELED = 'canceled';

    const STATUSES = [
        self:: STATUS_NEW,
        self:: STATUS_PENDING,
        self:: STATUS_PAID,
        self:: STATUS_CANCELED,
    ];

    public function pendingPayment(): OrderInterface;

    public function pay(): OrderInterface;

    public function cancel(): OrderInterface;

    public function getStatus(): string;

    public function getCustomer(): CustomerInterface;

    public function getCurrency(): CurrencyInterface;

    public function isEmpty(): bool;

    public function getSubtotalAmount(): float;

    public function getDiscountAmount(): float;

    public function getFirstTaxAmount(): float;

    public function getSecondTaxAmount(): float;

    public function getTaxAmount(): float;

    public function getTotalAmount(): float;

    /**
     * @return iterable|OrderItemInterface[]
     */
    public function getItems(): ?iterable;

    public function calculateAmounts(bool $bulk = false): CalculationInterface;
}
