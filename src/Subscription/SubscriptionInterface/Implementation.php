<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Subscription\SubscriptionInterface;

use ActiveCollab\Payments\Subscription\SubscriptionInterface;

trait Implementation
{
    public function canBeActivated(): bool
    {
        return $this->getStatus() === SubscriptionInterface::STATUS_PENDING;
    }

    public function canBeCanceled(): bool
    {
        return in_array($this->getStatus(), [
            SubscriptionInterface::STATUS_ACTIVE,
            SubscriptionInterface::STATUS_DEACTIVATED,
        ]);
    }

    public function canBeDeactivated(): bool
    {
        return $this->getStatus() === SubscriptionInterface::STATUS_ACTIVE;
    }

    public function canBePurchased(): bool
    {
        if ($this->getStatus() != SubscriptionInterface::STATUS_PENDING) {
            return false;
        }

        if ($this->isFree()) {
            return false;
        }

        return true;
    }

    public function isPaid(): bool
    {
        return !$this->isFree();
    }

    abstract public function getStatus(): string;

    abstract public function isFree(): bool;
}
