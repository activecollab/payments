<?php

namespace ActiveCollab\Payments\Order\Refund;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\DateValue\DateTimeValueInterface;

/**
 * @package ActiveCollab\Payments\Refund
 */
interface RefundInterface
{
    /**
     * Return parent gateway
     *
     * @return \ActiveCollab\Payments\Gateway\GatewayInterface
     */
    public function &getGateway();

    /**
     * Set parent gateway
     *
     * @param  \ActiveCollab\Payments\Gateway\GatewayInterface $gateway
     * @return $this
     */
    public function &setGateway(GatewayInterface &$gateway);

    /**
     * @return string
     */
    public function getRefundId();

    /**
     * @return string
     */
    public function getReference();

    /**
     * Return order by order ID
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * @return DateTimeValueInterface
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

    /**
     * Return true if this refund is partial
     *
     * @return boolean
     */
    public function isPartial();
}
