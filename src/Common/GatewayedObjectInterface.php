<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Common;

interface GatewayedObjectInterface
{
    /**
     * Return parent gateway.
     *
     * @return GatewayedObjectInterface
     */
    public function getGateway();
}