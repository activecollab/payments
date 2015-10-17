<?php

namespace ActiveCollab\Payments\Subscription\Cancelation;

use ActiveCollab\Payments\Gateway\GatewayInterface;

/**
 * @package ActiveCollab\Payments\Subscription\Cancelation
 */
interface CancelationInterface
{
    /**
     * Return parent gateway
     *
     * @return GatewayInterface
     */
    public function &getGateway();

    /**
     * Set parent gateway
     *
     * @param  GatewayInterface $gateway
     * @return $this
     */
    public function &setGateway(GatewayInterface &$gateway);

    /**
     * @return string
     */
    public function getCancelationId();

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
