<?php

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;

/**
 * @package ActiveCollab\Payments\Subscription
 */
interface SubscriptionInterface extends CommonOrderInterface
{
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';

    /**
     * Return next billing timestamp
     *
     * @return DateTimeValueInterface
     */
    public function getNextBillingTimestamp();

    /**
     * Set next billing timestamp
     *
     * @param  DateTimeValueInterface $value
     * @return $this
     */
    public function &setNextBillingTimestamp(DateTimeValueInterface $value);
}
