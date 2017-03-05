<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Product;

interface ProductItemInterface
{
    public function getDescription(): string;

    public function getQuantity(): float;

    public function getUnitCost(): float;
}
