<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Order\Calculator;

use ActiveCollab\Payments\Order\OrderInterface;

interface CalculatorInterface
{
    public function calculate(OrderInterface $order, int $calculation_precision = 2): CalculationInterface;
}
