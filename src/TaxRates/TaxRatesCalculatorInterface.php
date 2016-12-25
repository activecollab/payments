<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\TaxRates;

use ActiveCollab\Payments\Address\AddressInterface;

interface TaxRatesCalculatorInterface
{
    public function getTaxRate(AddressInterface $seller_address, AddressInterface $buyer_address, array $line_items): TaxRatesInterface;
}
