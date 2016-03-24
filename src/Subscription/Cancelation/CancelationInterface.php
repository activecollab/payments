<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\Subscription\Cancelation;

use ActiveCollab\Payments\Subscription\SubscriptionEventInterface;

/**
 * @package ActiveCollab\Payments\Subscription\Cancelation
 */
interface CancelationInterface extends SubscriptionEventInterface
{
    /**
     * @return string
     */
    public function getOurIdentifier();

    /**
     * Set our identifier.
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier($value);
}
