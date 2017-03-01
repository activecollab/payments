<?php

/*
 * This file is part of the Shepherd project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\GatewayResolver\GatewayResolverInterface;

use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\GatewayResolver\ResolvedGateways\ResolvedGateways;
use ActiveCollab\Payments\GatewayResolver\ResolvedGateways\ResolvedGatewaysInterface;
use ActiveCollab\Payments\Order\OrderInterface;

trait Implementation
{
    public function resolveGateways(?OrderInterface $order): ResolvedGatewaysInterface
    {
        return new ResolvedGateways(
            $this->getDefaultCreditCardGateway(),
            $this->getDefaultPayPalGateway()
        );
    }

    abstract public function getDefaultCreditCardGateway(): ?GatewayInterface;

    abstract public function getDefaultPayPalGateway(): ?GatewayInterface;
}
