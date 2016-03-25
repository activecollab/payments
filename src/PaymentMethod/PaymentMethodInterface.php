<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\PaymentMethod;

/**
 * @package ActiveCollab\Payments\PaymentMethod
 */
interface PaymentMethodInterface
{
    /**
     * Return payment method's reference (ID).
     *
     * @return string
     */
    public function getReference(): string;

    /**
     * Return our internal payment method reference.
     *
     * @return string
     */
    public function getOurReference(): string;

    /**
     * Return true if this payment method is active, or expired.
     *
     * @return bool
     */
    public function isExpired(): bool;
}
