<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test\Fixtures\Traits;

use ActiveCollab\Payments\Common\Traits\InternallyIdentifiedObject;
use ActiveCollab\Payments\Common\Traits\ReferencedObject;
use ActiveCollab\Payments\Common\Traits\TimestampedObject;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\CommonOrder\CommonOrderInterface
 */
trait CommonOrder
{
    use InternallyIdentifiedObject, ReferencedObject, TimestampedObject;

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
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
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
