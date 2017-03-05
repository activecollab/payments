<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Payments\TaxCategories\TaxCategoryInterface;

class TaxCategory implements TaxCategoryInterface
{
    private $category;

    public function __construct(string $category)
    {
        $this->category = $category;
    }
}
