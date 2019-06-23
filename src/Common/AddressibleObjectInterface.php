<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Common;

use ActiveCollab\Payments\Address\AddressInterface;

interface AddressibleObjectInterface
{
    public function getAddress(): ?AddressInterface;
}
