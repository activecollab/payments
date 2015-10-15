<?php

namespace ActiveCollab\Payments\Order;

use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;
use InvalidArgumentException;
use DateTime;

/**
 * @package ActiveCollab\Payments\Order
 */
class Order implements OrderInterface
{
    /**
     * @var string
     */
    private $order_id;

    /**
     * @var DateTime
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
     * @var float
     */
    private $tax = 0.0;

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
     * Construct a new order instance
     *
     * @param CustomerInterface $customer
     * @param string            $order_id
     * @param DateTime          $timestamp
     * @param string            $currency
     * @param float             $total
     * @param array             $items
     */
    public function __construct(CustomerInterface $customer, $order_id, DateTime $timestamp, $currency, $total, array $items)
    {
        if (empty($customer->getFullName()) || empty($customer->getEmail())) {
            throw new InvalidArgumentException('Customer name and email address is expected');
        }

        if (empty($order_id)) {
            throw new InvalidArgumentException('Order # is required');
        }

        if (empty($this->currency)) {
            throw new InvalidArgumentException('Currency code is required');
        }

        if ($total <= 0) {
            throw new InvalidArgumentException("Empty or credit orders are not supported");
        }

        if (empty($items)) {
            throw new InvalidArgumentException('Order items are required');
        }

        $this->customer = $customer;
        $this->order_id = $order_id;
        $this->timestamp = $timestamp;
        $this->currency = $currency;
        $this->total = (float) $total;
        $this->items = $items;
    }

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
     * @return DateTime
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
    public function getSubtotal()
    {
        return $this->getTotal() - $this->getTax();
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

    /**
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set order tax
     *
     * @param  float $value
     * @return $this
     */
    public function &setTax($value)
    {
        $this->tax = (float) $value;

        return $this;
    }
}
