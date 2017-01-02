<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\OrderItem\Calculator;

use ActiveCollab\Payments\OrderItem\OrderItemInterface;

interface CalculatorInterface
{
    public function calculate(OrderItemInterface $order_item, int $decimal_spaces = 2): CalculationInterface;
}
