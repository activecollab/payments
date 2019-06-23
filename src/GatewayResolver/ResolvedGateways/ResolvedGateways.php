<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */


declare(strict_types=1);

namespace ActiveCollab\Payments\GatewayResolver\ResolvedGateways;

use ActiveCollab\Payments\Gateway\GatewayInterface;

class ResolvedGateways implements ResolvedGatewaysInterface
{
    private $credit_card_gateway;

    private $pay_pal_gateway;

    public function __construct(GatewayInterface $credit_card_gateway = null, GatewayInterface $pay_pal_gateway = null)
    {
        $this->credit_card_gateway = $credit_card_gateway;
        $this->pay_pal_gateway = $pay_pal_gateway;
    }

    public function getCreditCardGateway(): ?GatewayInterface
    {
        return $this->credit_card_gateway;
    }

    public function getPayPalInterface(): ?GatewayInterface
    {
        return $this->pay_pal_gateway;
    }
}
