<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */


declare(strict_types=1);

namespace ActiveCollab\Payments\GatewayResolver\ResolvedGateways;

use ActiveCollab\Payments\Gateway\GatewayInterface;

interface ResolvedGatewaysInterface
{
    public function getCreditCardGateway(): ?GatewayInterface;

    public function getPayPalInterface(): ?GatewayInterface;
}
