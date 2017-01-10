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
use ActiveCollab\Payments\Currency\CurrencyInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;

/**
 * @package ActiveCollab\Payments\CommonOrder
 */
interface CommonOrderInterface extends ReferencedObjectInterface, InternallyIdentifiedObjectInterface, TimestampedObjectInterface
{
    public function getCustomer(): CustomerInterface;

    public function getCurrency(): CurrencyInterface;

    public function getSubtotalAmount(): float;

    public function getDiscountAmount(): float;

    public function getFirstTaxAmount(): float;

    public function getSecondTaxAmount(): float;

    public function getTaxAmount(): float;

    public function getTotalAmount(): float;

    /**
     * @return \ActiveCollab\Payments\OrderItem\OrderItemInterface[]
     */
    public function getItems();
}
