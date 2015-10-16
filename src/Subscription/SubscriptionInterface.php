<?php

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;

/**
 * @package ActiveCollab\Payments\Subscription
 */
interface SubscriptionInterface extends CommonOrderInterface
{
    /**
     * Return subscription beginning timestamp
     *
     * @return \DateTime
     */
    public function getBeginTimestamp();

    /**
     * Return subscription end timestamp
     *
     * @return \DateTime
     */
    public function getEndTimestamp();

    /**
     * Return next billing timestamp
     *
     * @return \DateTime
     */
    public function getNextBillingTimestamp();
}
