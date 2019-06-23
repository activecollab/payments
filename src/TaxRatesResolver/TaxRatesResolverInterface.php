<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\TaxRatesResolver;

use ActiveCollab\Payments\Order\OrderInterface;

interface TaxRatesResolverInterface
{
    public function resolveTaxRates(OrderInterface $order): OrderInterface;
}
