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
use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;

interface SubscriptionInterface extends CommonOrderInterface, GatewayedObjectInterface
{
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';

    public function getBillingPeriod(): string;

    public function getNextBillingTimestamp(): DateTimeValueInterface;

    public function &setNextBillingTimestamp(DateTimeValueInterface $value): SubscriptionInterface;

    public function calculateNextBillingTimestamp(DateTimeValueInterface $reference): DateTimeValueInterface;
}
