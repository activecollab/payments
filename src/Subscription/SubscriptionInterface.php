<?php

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;

/**
 * @package ActiveCollab\Payments\Subscription
 */
interface SubscriptionInterface extends CommonOrderInterface
{
    public function getBeginTimestamp();

    public function getEndTimestamp();

    public function getNextBillingTimestamp();
}
