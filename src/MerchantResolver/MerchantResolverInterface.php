<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\MerchantResolver;

use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Merchant\MerchantInterface;
use ActiveCollab\Payments\Product\ProductInterface;

interface MerchantResolverInterface
{
    public function resolveMerchant(ProductInterface $product, ?CustomerInterface $customer): MerchantInterface;
}
