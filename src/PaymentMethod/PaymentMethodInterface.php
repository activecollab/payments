<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\PaymentMethod;

use ActiveCollab\DateValue\DateValueInterface;
use ActiveCollab\Payments\Common\InternallyIdentifiedObjectInterface;
use ActiveCollab\Payments\Common\ReferencedObjectInterface;

/**
 * @package ActiveCollab\Payments\PaymentMethod
 */
interface PaymentMethodInterface extends InternallyIdentifiedObjectInterface, ReferencedObjectInterface
{
    const CREDIT_CARD = 'credit_card';
    const PAYPAL = 'paypal';
    const APPLE_PAY = 'apple_pay';
    const OTHER = 'other';

    const CARD_AMEX = 'American Express';
    const CARD_CARTE_BLANCHE = 'Carte Blanche';
    const CARD_CHINA_UNIONPAY = 'China UnionPay';
    const CARD_DINERS_CLUB = 'Diners Club';
    const CARD_DISCOVER = 'Discover';
    const CARD_JCB = 'JCB';
    const CARD_LASER = 'Laser';
    const CARD_MAESTRO = 'Maestro';
    const CARD_MASTERCARD = 'MasterCard';
    const CARD_SOLO = 'Solo';
    const CARD_SWITCH = 'Switch';
    const CARD_VISA = 'Visa';
    const CARD_UNKNOWN = 'Unknown';

    /**
     * Return payment method type.
     *
     * @return string
     */
    public function getPaymentMethodType();

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
