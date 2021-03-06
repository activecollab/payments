<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Object\ObjectInterface\Implementation as ObjectInterfaceImplementation;
use ActiveCollab\Payments\Common\Traits\InternallyIdentifiedObject;
use ActiveCollab\Payments\Common\Traits\ReferencedObject;
use ActiveCollab\Payments\Common\Traits\TimestampedObject;
use ActiveCollab\Payments\Currency\CurrencyInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Order\Calculator\CalculationInterface;
use ActiveCollab\Payments\Order\Calculator\Calculator;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\Order
 */
class Order implements OrderInterface
{
    use InternallyIdentifiedObject, ObjectInterfaceImplementation, ReferencedObject, TimestampedObject;

    /**
     * @var int
     */
    private $id = 1;

    /**
     * @var string
     */
    private $status = OrderInterface::STATUS_NEW;

    /**
     * @var CalculationInterface
     */
    private $calculation;

    /**
     * @var CurrencyInterface
     */
    private $currency;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var OrderItemInterface[]
     */
    private $items;

    /**
     * Construct a new order instance.
     *
     * @param CustomerInterface      $customer
     * @param string                 $reference
     * @param DateTimeValueInterface $timestamp
     * @param string                 $currency
     * @param array                  $items
     */
    public function __construct(CustomerInterface $customer, $reference, DateTimeValueInterface $timestamp, $currency, array $items)
    {
        $this->validateCustomer($customer);
        $this->validateOrderId($reference);
        $this->validateCurrency($currency);
        $this->validateItems($items);

        $this->customer = $customer;
        $this->reference = $reference;
        $this->setTimestamp($timestamp);
        $this->currency = $currency;
        $this->items = $items;
        $this->calculation = (new Calculator())->calculate($this, 2);
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

    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param  string               $value
     * @return $this|OrderInterface
     */
    public function &setStatus(string $value): OrderInterface
    {
        if (!in_array($value, OrderInterface::STATUSES)) {
            throw new InvalidArgumentException('Valid status is required.');
        }

        $this->status = $value;

        return $this;
    }

    public function pendingPayment(): OrderInterface
    {
        $this->setStatus(self::STATUS_PENDING);

        return $this;
    }

    public function pay(): OrderInterface
    {
        $this->setStatus(self::STATUS_PAID);

        return $this;
    }

    public function cancel(): OrderInterface
    {
        $this->setStatus(self::STATUS_CANCELED);

        return $this;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
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

    /**
     * @return iterable|OrderItemInterface[]
     */
    public function getItems(): ?iterable
    {
        return $this->items;
    }

    public function calculateAmounts(bool $bulk = false): CalculationInterface
    {
        return $this->calculation;
    }

    /**
     * Validate if we got a good Customer instance.
     *
     * @param CustomerInterface $value
     */
    protected function validateCustomer(CustomerInterface $value)
    {
        if (empty($value->getFullName()) || empty($value->getEmail())) {
            throw new InvalidArgumentException('Customer name and email address is expected');
        }
    }

    /**
     * Validate if we got a good order ID.
     *
     * @param string $value
     */
    protected function validateOrderId($value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Order # is required');
        }
    }

    /**
     * Validate if we got good currency code.
     *
     * @param string $value
     */
    public function validateCurrency($value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Currency code is required');
        }
    }

    /**
     * Validate if we got good order items.
     *
     * @param OrderItemInterface[] $value
     */
    protected function validateItems($value)
    {
        if (!is_array($value) || empty($value)) {
            throw new InvalidArgumentException('Order items are required');
        }
    }
}
