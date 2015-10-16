<?php

namespace ActiveCollab\Payments\CommonOrder\CommonOrderInterface;

use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;
use InvalidArgumentException;

/**
 * @package ActiveCollab\Payments\CommonOrder\CommonOrderInterface
 */
trait Implementation
{
    /**
     * @var string
     */
    private $order_id;

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
     * Return order ID
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Return date and time when this order was made
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
     * Return our internal order indetifier (if present)
     *
     * @return string
     */
    public function getOurIdentifier()
    {
        return $this->our_identifier;
    }

    /**
     * Set our identifier
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier($value)
    {
        $this->our_identifier = trim($value);

        return $this;
    }

    protected function validateCustomer(CustomerInterface $value)
    {
        if (empty($value->getFullName()) || empty($value->getEmail())) {
            throw new InvalidArgumentException('Customer name and email address is expected');
        }
    }

    protected function validateOrderId($value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Order # is required');
        }
    }

    public function validateCurrency($value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Currency code is required');
        }
    }

    protected function validateTotal($value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Empty or credit orders are not supported");
        }
    }

    protected function validateItems($value)
    {
        if (!is_array($value) || empty($value)) {
            throw new InvalidArgumentException('Order items are required');
        }
    }
}