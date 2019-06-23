<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Order\Calculator;

use ActiveCollab\Payments\Order\OrderInterface;

class Calculator implements CalculatorInterface
{
    public function calculate(OrderInterface $order, int $calculation_precision = 2): CalculationInterface
    {
        $amounts = array_fill(0, 4, 0.0);

        foreach ($order->getItems() as $order_item) {
            $order_item_calculation = $order_item->calculateAmounts(true);

            $amounts[0] += $order_item_calculation->getSubtotal();
            $amounts[1] += $order_item_calculation->getDiscount();
            $amounts[2] += $order_item_calculation->getFirstTax();
            $amounts[3] += $order_item_calculation->getSecondTax();
        }

        foreach ($amounts as $k => $v) {
            $amounts[$k] = round($v, $calculation_precision);
        }

        return new Calculation(...$amounts);
    }
}
