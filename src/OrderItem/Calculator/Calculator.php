<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\OrderItem\Calculator;

use ActiveCollab\Payments\OrderItem\OrderItemInterface;

class Calculator implements CalculatorInterface
{
    public function calculate(OrderItemInterface $order_item, int $calculation_precision = 2): CalculationInterface
    {
        $subtotal_amount = $this->calculateSubtotal($order_item->getUnitCost(), $order_item->getQuantity(), $calculation_precision);

        $discount = $order_item->getDiscount();

        $per_unit_discount = $discount ? $discount->calculateForAmount($order_item->getUnitCost()) : 0;
        $discount_amount = $discount ? $discount->calculateForAmount($subtotal_amount) : 0;

        $first_tax_amount = $this->calculateFirstTax(
            $order_item->getFirstTaxRate(),
            $order_item->getUnitCost(),
            $order_item->getQuantity(),
            $per_unit_discount
        );

        $second_tax_amount = $this->calculateSecondTax(
            $order_item->getSecondTaxRate(),
            (bool) $order_item->getSecondTaxIsCompound(),
            $first_tax_amount,
            $order_item->getUnitCost(),
            $order_item->getQuantity(),
            $per_unit_discount
        );

        return new Calculation($subtotal_amount, $discount_amount, $first_tax_amount, $second_tax_amount);
    }

    private function calculateSubtotal(float $unit_cost, float $quantity, int $decimal_spaces)
    {
        return round($unit_cost * $quantity, $decimal_spaces);
    }

    private function calculateFirstTax(?float $tax_rate, float $unit_cost, float $quantity, float $unit_discount): float
    {
        if (!empty($tax_rate)) {
            return $quantity * ($unit_cost - $unit_discount) * $tax_rate / 100;
        }

        return 0;
    }

    private function calculateSecondTax(?float $tax_rate, bool $tax_is_compound, float $first_tax_amount, float $unit_cost, float $quantity, float $unit_discount): float
    {
        if (!empty($tax_rate)) {
            $taxable_amount = $quantity * ($unit_cost - $unit_discount);

            if ($tax_is_compound) {
                $taxable_amount += $first_tax_amount;
            }

            return $taxable_amount * $tax_rate / 100;
        }

        return 0;
    }
}
