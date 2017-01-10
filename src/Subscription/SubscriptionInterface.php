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
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';

    const BILLING_PERIODS = [self::MONTHLY, self::YEARLY];

    public function getBillingPeriod(): string;

    public function getNextBillingTimestamp(): DateTimeValueInterface;

    public function &setNextBillingTimestamp(DateTimeValueInterface $value): SubscriptionInterface;

    public function calculateNextBillingTimestamp(DateTimeValueInterface $reference): DateTimeValueInterface;
}
