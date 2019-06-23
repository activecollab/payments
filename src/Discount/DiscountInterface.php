<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Discount;

use ActiveCollab\Object\ObjectInterface;

/**
 * @package ActiveCollab\Payments\Discount
 */
interface DiscountInterface extends ObjectInterface
{
    /** @deprecated */
    const PERCENT = 'percent';
    /** @deprecated */
    const VALUE = 'fixed';

    const TYPE_PERCENT = 'percent';
    const TYPE_VALUE = 'fixed';

    const DISCOUNT_TYPES = [self::TYPE_PERCENT, self::TYPE_VALUE];

    /**
     * Return discount name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Return amount of discount.
     *
     * @return float
     */
    public function getValue(): float;

    /**
     * Return maximum amount that this discount can substract from the order.
     *
     * NULL is interepreted as "no max amount".
     *
     * @return float
     */
    public function getMaxAmount(): ?float;

    /**
     * Return type of discount (percentage or fixed).
     *
     * @return string
     */
    public function getDiscountType(): string;

    /**
     * Calcualte discount for the given amount.
     *
     * @param  float $amount
     * @return float
     */
    public function calculateForAmount(float $amount): float;
}
