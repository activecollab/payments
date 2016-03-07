<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\CommonOrder\CommonOrderInterface;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\CommonOrder\CommonOrderInterface
 */
trait Implementation
{
    /**
     * @var string
     */
    private $reference;

    /**
     * @var DateTimeValueInterface
     */
    private $timestamp;

    /**
     * @var string
     */
    private $our_identifier = '';

    /**
     * @var float
     */
    private $total = 0.0;

    /**
     * @var string
     */
    private $currency = 'USD';

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var OrderItemInterface[]
     */
    private $items;

    /**
     * Return order reference (order ID).
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Return date and time when this order was made.
     *
     * @return DateTimeValueInterface
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return \ActiveCollab\Payments\OrderItem\OrderItemInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Return our internal order indetifier (if present).
     *
     * @return string
     */
    public function getOurIdentifier()
    {
        return $this->our_identifier;
    }

    /**
     * Set our identifier.
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier($value)
    {
        $this->our_identifier = trim($value);

        return $this;
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
     * Validate if we got good total order value.
     *
     * @param float $value
     */
    protected function validateTotal($value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Empty or credit orders are not supported');
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
