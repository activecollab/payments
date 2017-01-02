<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Payments\Discount\DiscountInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\OrderItem\Calculator\CalculationInterface;
use ActiveCollab\Payments\OrderItem\Calculator\Calculator;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use InvalidArgumentException;
use LogicException;

class OrderItem implements OrderItemInterface
{
    /**
     * @var OrderInterface
     */
    private $order;

    /**
     * @var DiscountInterface|null
     */
    private $discount;

    private $description;
    private $quantity;
    private $unit_cost;
    private $first_tax_rate;
    private $second_tax_rate;
    private $second_tax_is_compound;

    public function __construct(string $description, float $quantity, float $unit_cost, float $first_tax_rate = null, float $second_tax_rate = null, bool $second_tax_is_compound = null)
    {
        if (empty($description)) {
            throw new InvalidArgumentException('Discount is required.');
        }

        if ($quantity <= 0) {
            throw new InvalidArgumentException('Quantity is required.');
        }

        if ($unit_cost <= 0) {
            throw new InvalidArgumentException('Unit cost is required.');
        }

        $this->description = $description;
        $this->quantity = $quantity;
        $this->unit_cost = $unit_cost;
        $this->first_tax_rate = $first_tax_rate;
        $this->second_tax_rate = $second_tax_rate;
        $this->second_tax_is_compound = $second_tax_is_compound;
    }

    public function getOrder(): OrderInterface
    {
        if (empty($this->order)) {
            throw new LogicException("Order can't be accessed prior to being set.");
        }

        return $this->order;
    }

    public function &setOrder(OrderInterface $order = null): OrderItemInterface
    {
        $this->order = $order;

        return $this;
    }

    public function getDiscount(): ?DiscountInterface
    {
        return $this->discount;
    }

    public function &setDiscount(DiscountInterface $discount = null): OrderItemInterface
    {
        $this->discount = $discount;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnitCost(): float
    {
        return $this->unit_cost;
    }

    public function getFirstTaxRate(): ?float
    {
        return $this->first_tax_rate;
    }

    public function getSecondTaxRate(): ?float
    {
        return $this->second_tax_rate;
    }

    public function getSecondTaxIsCompound(): ?bool
    {
        return $this->second_tax_is_compound;
    }

    public function getCalculationPrecision(): int
    {
        return 2;
    }

    public function calculateAmounts(bool $bulk = false): CalculationInterface
    {
        return (new Calculator())
            ->calculate($this, $this->getCalculationPrecision());
    }
}
