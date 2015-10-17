<?php

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
    public function getReference();

    /**
     * @return string
     */
    public function getOurIdentifier();

    /**
     * Set our identifier
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier($value);
}
