<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\CommonOrder;

use ActiveCollab\Payments\Common\InternallyIdentifiedObjectInterface;
use ActiveCollab\Payments\Common\ReferencedObjectInterface;
use ActiveCollab\Payments\Common\TimestampedObjectInterface;

/**
 * @package ActiveCollab\Payments\CommonOrder
 */
interface CommonOrderInterface extends ReferencedObjectInterface, InternallyIdentifiedObjectInterface, TimestampedObjectInterface
{
    /**
     * @return \ActiveCollab\Payments\Customer\CustomerInterface
     */
    public function getCustomer();

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
}
