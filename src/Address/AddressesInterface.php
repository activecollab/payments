<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Address;

use Traversable;

interface AddressesInterface
{
    public function getAddresses(): ?Traversable;

    public function &addAddresses(AddressInterface ...$addresses): AddressesInterface;

    public function &clearAddresses(): AddressesInterface;
}
