<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Address;

interface MerchantAddressInterface extends AddressInterface
{
    public function getMerchantName(): ?string;

    public function getTaxId(): ?string;
}
