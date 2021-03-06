<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Object\ObjectInterface\Implementation as ObjectInterfaceImplementation;
use ActiveCollab\Payments\Discount\DiscountInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\OrderItem\Calculator\CalculationInterface;
use ActiveCollab\Payments\OrderItem\Calculator\Calculator;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use ActiveCollab\Payments\TaxCategories\TaxCategoryInterface;
use InvalidArgumentException;
use LogicException;

class OrderItem implements OrderItemInterface
{
    use ObjectInterfaceImplementation;

    private $id = 1;

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
    private $tax_category;
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

    public function getId()
    {
        return $this->id;
    }

    public function &setId($value)
    {
        $this->id = $value;

        return $this;
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

    private $short_description = '';

    public function getShortDescription(): string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): OrderItemInterface
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnitCost(): float
    {
        return $this->unit_cost;
    }

    public function getTaxCategory(): TaxCategoryInterface
    {
        if ($this->tax_category) {
            return $this->tax_category;
        }

        return new TaxCategory(TaxCategoryInterface::OTHER);
    }

    public function &setTaxCategory(?TaxCategoryInterface $tax_category)
    {
        $this->tax_category = $tax_category;

        return $this;
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

    public function getSubtotalAmount(): float
    {
        return $this->calculateAmounts()->getSubtotal();
    }

    public function getDiscountAmount(): float
    {
        return $this->calculateAmounts()->getDiscount();
    }

    public function getFirstTaxAmount(): float
    {
        return $this->calculateAmounts()->getFirstTax();
    }

    public function getSecondTaxAmount(): float
    {
        return $this->calculateAmounts()->getSecondTax();
    }

    public function getTaxAmount(): float
    {
        return $this->calculateAmounts()->getTax();
    }

    public function getTotalAmount(): float
    {
        return $this->calculateAmounts()->getTotal();
    }

    public function calculateAmounts(bool $bulk = false): CalculationInterface
    {
        return (new Calculator())->calculate($this, 2);
    }
}
