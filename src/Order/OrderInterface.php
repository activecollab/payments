<?php

namespace ActiveCollab\Payments\Order;

/**
 * @package ActiveCollab\Payments\Order
 */
interface OrderInterface
{
    /**
     * @return string
     */
    public function getOrderId();

    /**
     * @return \ActiveCollab\Payments\Customer\CustomerInterface
     */
    public function getCustomer();

    /**
     * @return \DateTime
     */
    public function getTimestamp();

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @return float
     */
    public function getSubtotal();

    /**
     * @return float
     */
    public function getTotal();

    /**
     * @return \ActiveCollab\Payments\OrderItem\OrderItemInterface[]
     */
    public function getItems();

    /**
     * @return string
     */
    public function getOurIdentifier();

    /**
     * Set our identifier
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier($value);

    /**
     * @return float
     */
    public function getTax();

    /**
     * Set order tax
     *
     * @param  float $value
     * @return $this
     */
    public function &setTax($value);
}
