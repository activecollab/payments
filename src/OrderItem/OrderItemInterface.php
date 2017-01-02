<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\OrderItem;

use ActiveCollab\Payments\Discount\DiscountInterface;
use ActiveCollab\Payments\OrderItem\Calculator\CalculationInterface;

interface OrderItemInterface
{
    public function getDescription(): string;

    public function getQuantity(): float;

    public function getUnitCost(): float;

    public function getFirstTaxRate(): ?float;

    public function getSecondTaxRate(): ?float;

    public function getSecondTaxIsCompound(): ?bool;

    public function getDiscount(): ?DiscountInterface;

    public function getCalculationPrecision(): int;

    public function calculateAmounts(): CalculationInterface;
}
