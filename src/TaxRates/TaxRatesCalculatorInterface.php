<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\TaxRates;

use ActiveCollab\Payments\Address\Address;

interface TaxRatesCalculatorInterface
{
    public function getTaxRate(Address $seller_address, Address $buyer_address, array $line_items): TaxRatesInterface;
}
