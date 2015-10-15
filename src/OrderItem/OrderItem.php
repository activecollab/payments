<?php

namespace ActiveCollab\Payments\OrderItem;

/**
 * @package ActiveCollab\Payments\OrderItem
 */
class OrderItem implements OrderItemInterface
{
    /**
     * @var string
     */
    public $description;

    /**
     * @var float|int
     */
    private $quantity = 1;

    /**
     * @var float
     */
    private $unit_cost = 0.0;

    /**
     * @param string        $description
     * @param float|integer $quantity
     * @param float         $unit_cost
     */
    public function __construct($description, $quantity, $unit_cost)
    {
        $this->description = trim($description);
        $this->quantity = $quantity;
        $this->unit_cost = $unit_cost;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return float|int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getUnitCost()
    {
        return $this->unit_cost;
    }
}
