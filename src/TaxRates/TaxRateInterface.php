<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\TaxRates;

interface TaxRateInterface
{
    public function getTaxableAmount(): float;
    public function getCollectableTax(): float;
    public function getCombinedTaxRate(): float;
}
