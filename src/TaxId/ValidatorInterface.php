<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\TaxId;

interface ValidatorInterface
{
    public function isValid(string $country_code, string $tax_id): ? bool;
}
