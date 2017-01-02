<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\OrderItem\Calculator;

interface CalculationInterface
{
    public function getSubtotal(): float;

    public function getDiscount(): float;

    public function getFirstTax(): float;

    public function getSecondTax(): float;

    public function getTax(): float;

    public function getTotal(): float;
}
