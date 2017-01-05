<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Address;

interface CustomerAddressInterface extends AddressInterface
{
    public function getFirstName(): ?string;

    public function getLastName(): ?string;

    public function getOrganisationName(): ?string;

    public function getTaxId(): ?string;
}
