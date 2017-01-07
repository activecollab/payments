<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Merchant;

use ActiveCollab\Payments\Gateway\GatewayInterface;

interface MerchantInterface
{
    public function getReference(GatewayInterface $gateway): string;

    public function getOurReference(): string;
}
