<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Common\GatewayedObjectInterface;
use ActiveCollab\Payments\Common\InternallyIdentifiedObjectInterface;
use ActiveCollab\Payments\Common\ReferencedObjectInterface;
use ActiveCollab\Payments\Common\TimestampedObjectInterface;
use ActiveCollab\Payments\Product\ProductInterface;

interface SubscriptionInterface extends
    GatewayedObjectInterface,
    InternallyIdentifiedObjectInterface,
    ProductInterface,
    ReferencedObjectInterface,
    TimestampedObjectInterface
{
    const BILLING_PERIOD_NONE = 'none';
    const BILLING_PERIOD_MONTHLY = 'monthly';
    const BILLING_PERIOD_YEARLY = 'yearly';

    const BILLING_PERIODS = [
        self::BILLING_PERIOD_NONE,
        self::BILLING_PERIOD_MONTHLY,
        self::BILLING_PERIOD_YEARLY
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';
    const STATUS_DEACTIVATED = 'deactivated';

    const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_ACTIVE,
        self::STATUS_CANCELED,
        self::STATUS_DEACTIVATED,
    ];

    public function getStatus(): string;

    public function getBillingPeriod(): string;

    public function getNextBillingTimestamp(): DateTimeValueInterface;

    public function &setNextBillingTimestamp(DateTimeValueInterface $value): SubscriptionInterface;

    public function calculateNextBillingTimestamp(DateTimeValueInterface $reference): DateTimeValueInterface;

    public function isFree(): bool;

    public function isPaid(): bool;

    public function canBePurchased(): bool;
}
