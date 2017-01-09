<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Customer;

use ActiveCollab\Payments\Common\ReferencedObjectInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\PaymentMethod\PaymentMethodInterface;
use ActiveCollab\User\UserInterface;

interface CustomerInterface extends ReferencedObjectInterface, UserInterface
{
//    public function getReference(GatewayInterface $gateway);

    public function getOurReference();

    public function getPaymentMethods(GatewayInterface $gateway): array;

    public function getDefaultPaymentMethod(GatewayInterface $gateway): ?PaymentMethodInterface;

    public function addPaymentMethod(GatewayInterface $gateway, bool $set_as_default, ...$arguments): PaymentMethodInterface;
}
