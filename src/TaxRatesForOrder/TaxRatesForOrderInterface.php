<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\TaxRatesForOrder;

use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\OrderItem\OrderItemInterface;

interface TaxRatesForOrderInterface
{
    public function getOrder(): OrderInterface;

    public function getTaxableAmount(): float;

    public function getTaxAmount(): float;

    public function getFirstTaxRateFor(OrderItemInterface $order_item): ?float;

    public function getSecondTaxRateFor(OrderItemInterface $order_item): ?float;

    public function getSecondTaxRateIsCompoundFor(OrderItemInterface $order_item): ?bool;
}
