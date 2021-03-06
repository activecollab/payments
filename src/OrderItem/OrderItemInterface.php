<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\OrderItem;

use ActiveCollab\Object\ObjectInterface;
use ActiveCollab\Payments\Discount\DiscountInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\OrderItem\Calculator\CalculationInterface;
use ActiveCollab\Payments\TaxCategories\TaxCategoryInterface;

interface OrderItemInterface extends ObjectInterface
{
    public function getOrder(): OrderInterface;

    public function getDescription(): string;

    public function getShortDescription(): string;

    public function getQuantity(): float;

    public function getUnitCost(): float;

    public function getTaxCategory(): TaxCategoryInterface;

    public function getFirstTaxRate(): ?float;

    public function getSecondTaxRate(): ?float;

    public function getSecondTaxIsCompound(): ?bool;

    public function getDiscount(): ?DiscountInterface;

    public function getSubtotalAmount(): float;

    public function getDiscountAmount(): float;

    public function getFirstTaxAmount(): float;

    public function getSecondTaxAmount(): float;

    public function getTaxAmount(): float;

    public function getTotalAmount(): float;

    /**
     * Calculate totals, amounts, and taxes, and return calculation instance.
     *
     * $bulk should be set to TRUE when you are iterating over all order items and calling calculate method.
     *
     * @param  bool                 $bulk
     * @return CalculationInterface
     */
    public function calculateAmounts(bool $bulk = false): CalculationInterface;
}
