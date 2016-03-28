<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\PaymentMethod;

use ActiveCollab\DateValue\DateValueInterface;

/**
 * @package ActiveCollab\Payments\PaymentMethod
 */
interface PaymentMethodInterface
{
    const CREDIT_CARD = 'credit_card';
    const PAY_PAL = 'pay_pal';
    const APPLE_PAY = 'apple_pay';
    const OTHER = 'other';

    /**
     * Return payment method type.
     *
     * @return string
     */
    public function getPaymentMethodType();

    /**
     * Return payment method's reference on the gateway (ID).
     *
     * @return string|null
     */
    public function getReference();

    /**
     * Return our internal payment method reference.
     *
     * @return string|null
     */
    public function getOurReference();

    /**
     * Return a reference that customer can use to indetify the payment method (masked card number, PayPal account etc).
     * 
     * @return string
     */
    public function getCustomerReference();

    /**
     * Return the date when this payment method is expected to expire.
     *
     * @return DateValueInterface
     */
    public function getExpiresOn();

    /**
     * Return true if this payment method is active, or expired.
     *
     * @return bool
     */
    public function isExpired(): bool;

    /**
     * Return true if this payment method can be used more than once.
     *
     * @return bool
     */
    public function isReusable(): bool;

    /**
     * Return arguments that are needed so this payment method can be used again.
     *
     * @return mixed
     */
    public function getReuseArguments();
}
