<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Product;

use ActiveCollab\Object\ObjectInterface;
use ActiveCollab\Payments\TaxCategories\TaxCategoryInterface;

interface ProductInterface extends ObjectInterface
{
    public function getInvoicingContext();

    public function canBePurchased(): bool;

    public function getTaxCategory(): TaxCategoryInterface;
}
