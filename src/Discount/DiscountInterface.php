<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Discount;

/**
 * @package ActiveCollab\Payments\Discount
 */
interface DiscountInterface
{
    const VALUE = 'fixed';
    const PERCENT = 'percent';

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
    public function getAmount(): float;

    /**
     * Return type of discount (percentage or fixed).
     *
     * @return string
     */
    public function getType(): string;
}
