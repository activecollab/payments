<?php

/*
 * This file is part of the Shepherd project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\GatewayResolver;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\GatewayResolver\ResolvedGateways\ResolvedGatewaysInterface;
use ActiveCollab\Payments\Order\OrderInterface;

interface GatewayResolverInterface
{
    public function resolveGateways(?OrderInterface $order): ResolvedGatewaysInterface;

    public function getDefaultCreditCardGateway(): ?GatewayInterface;

    public function getDefaultPayPalGateway(): ?GatewayInterface;
}
