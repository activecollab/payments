<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Common;

use ActiveCollab\Payments\Gateway\GatewayInterface;

interface GatewayedObjectInterface
{
    /**
     * Return parent gateway.
     *
     * @return GatewayInterface
     */
    public function getGateway();
}
