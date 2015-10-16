<?php

namespace ActiveCollab\Payments\CommonOrder;

/**
 * @package ActiveCollab\Payments\CommonOrder
 */
interface CommonOrderInterface
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
}