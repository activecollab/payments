<?php

namespace ActiveCollab\Payments\Refund;

/**
 * @package ActiveCollab\Payments\Refund
 */
interface RefundInterface
{
    /**
     * @return string
     */
    public function getRefundId();

    /**
     * @return string
     */
    public function getOrderId();

    /**
     * @return \DateTime
     */
    public function getTimestamp();

    /**
     * @return float
     */
    public function getTotal();

    /**
     * @return \ActiveCollab\Payments\OrderItem\OrderItemInterface[]
     */
    public function getItems();

    /**
     * Set refund items, if refund was by line item
     *
     * @param  \ActiveCollab\Payments\OrderItem\OrderItemInterface[] $value
     * @return $this
     */
    public function &setItems(array $value);

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
