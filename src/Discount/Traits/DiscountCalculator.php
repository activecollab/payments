<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Discount\Traits;

use ActiveCollab\Payments\Discount\DiscountInterface;

trait DiscountCalculator
{
    public function calculateForAmount(float $amount): float
    {
        if ($this->getType() === DiscountInterface::VALUE) {
            $discount = $this->getValue();
        } else {
            $discount = $this->calculateDiscountByRate($amount, $this->getValue());
        }

        return $this->getDiscountUpToMaxAmount($discount, $this->getMaxAmount());
    }

    private function calculateDiscountByRate(float $amount, float $discount_rate): float
    {
        return $amount * $discount_rate / 100;
    }

    private function getDiscountUpToMaxAmount(float $discount, ?float $max_amount): float
    {
        if ($max_amount && $discount > $max_amount) {
            return $max_amount;
        }

        return $discount;
    }

    abstract public function getValue(): float;

    abstract public function getMaxAmount(): ?float;

    abstract public function getType(): string;
}
