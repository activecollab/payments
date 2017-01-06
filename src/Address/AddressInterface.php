<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Address;

interface AddressInterface
{
    public function getName(): string;

    public function isOrganization(): bool;

    public function getTaxId(): ?string;

    public function getAddress(): string;

    public function getAddressExtended(): ?string;

    public function getCity(): string;

    public function getZipCode(): string;

    public function getRegion(): ?string;

    public function getCountryCode(): string;
}
