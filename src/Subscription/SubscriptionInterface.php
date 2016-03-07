<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Subscription;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\CommonOrder\CommonOrderInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;

/**
 * @package ActiveCollab\Payments\Subscription
 */
interface SubscriptionInterface extends CommonOrderInterface
{
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';

    /**
     * Return parent gateway.
     *
     * @return GatewayInterface
     */
    public function &getGateway();

    /**
     * Set parent gateway.
     *
     * @param  GatewayInterface $gateway
     * @return $this
     */
    public function &setGateway(GatewayInterface &$gateway);

    /**
     * Return next billing timestamp.
     *
     * @return DateTimeValueInterface
     */
    public function getNextBillingTimestamp();

    /**
     * Set next billing timestamp.
     *
     * @param  DateTimeValueInterface $value
     * @return $this
     */
    public function &setNextBillingTimestamp(DateTimeValueInterface $value);

    /**
     * Calculate next billing period based on reference timestamp.
     *
     * @param  DateTimeValueInterface $reference
     * @return DateTimeValueInterface
     */
    public function calculateNextBillingTimestamp(DateTimeValueInterface $reference);
}
