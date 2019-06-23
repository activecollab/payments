<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Order\Calculator;


class Calculation implements CalculationInterface
{
    private $subtotal_amount;
    private $discount_amount;
    private $first_tax_amount;
    private $second_tax_amount;

    public function __construct(float $subtotal_amount, float $discount_amount, float $first_tax_amount, float $second_tax_amount)
    {
        $this->subtotal_amount = $subtotal_amount;
        $this->discount_amount = $discount_amount;
        $this->first_tax_amount = $first_tax_amount;
        $this->second_tax_amount = $second_tax_amount;
    }

    public function getSubtotal(): float
    {
        return $this->subtotal_amount;
    }

    public function getDiscount(): float
    {
        return $this->discount_amount;
    }

    public function getFirstTax(): float
    {
        return $this->first_tax_amount;
    }

    public function getSecondTax(): float
    {
        return $this->second_tax_amount;
    }

    public function getTax(): float
    {
        return $this->getFirstTax() + $this->getSecondTax();
    }

    public function getTotal(): float
    {
        return $this->getSubtotal() - $this->getDiscount() + $this->getTax();
    }
}
