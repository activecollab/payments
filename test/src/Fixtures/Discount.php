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
use ActiveCollab\Payments\Discount\Traits\DiscountCalculator;
use ActiveCollab\Payments\Discount\Traits\DiscountValidator;

class Discount implements DiscountInterface
{
    use DiscountCalculator, DiscountValidator, ObjectInterfaceImplementation;

    /**
     * @var int
     */
    private $id = 1;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var float
     */
    private $value;

    /**
     * @var float|null
     */
    private $max_amount;

    public function __construct(string $name, float $value, string $type = DiscountInterface::PERCENT, float $max_amount = null)
    {
        $this->validateDiscountName($name);
        $this->validateDiscountType($type);
        $this->validateDiscountValue($type, $value);
        $this->validateMaxDiscountAmount($type, $max_amount);

        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->max_amount = $max_amount;
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

    /**
     * Return discount name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return amount of discount.
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Return type of discount (percentage or fixed).
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Return maximum amount that this discount can substract from the order.
     *
     * NULL is interepreted as "no max amount".
     *
     * @return float
     */
    public function getMaxAmount(): ?float
    {
        return $this->max_amount;
    }
}
