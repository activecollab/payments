<?php

namespace ActiveCollab\Payments\Subscription\Rebill;

use ActiveCollab\Payments\Subscription\SubscriptionEventInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;

/**
 * @package ActiveCollab\Payments\Subscription\Rebill
 */
interface RebillInterface extends SubscriptionEventInterface
{
    /**
     * Return next billing timestamp
     *
     * @return DateTimeValueInterface
     */
    public function getNextBillingTimestamp();
}
