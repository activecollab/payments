<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Subscription\Rebill;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Subscription\SubscriptionEventInterface;

/**
 * @package ActiveCollab\Payments\Subscription\Rebill
 */
interface RebillInterface extends SubscriptionEventInterface
{
    /**
     * Return next billing timestamp.
     *
     * @return DateTimeValueInterface
     */
    public function getNextBillingTimestamp();
}
