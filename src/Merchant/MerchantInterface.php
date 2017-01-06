<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Merchant;

use ActiveCollab\Payments\Common\AddressibleObjectInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;

interface MerchantInterface extends AddressibleObjectInterface
{
    public function getReference(GatewayInterface $gateway);

    public function getOurReference();
}
