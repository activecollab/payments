<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Object\ObjectInterface\Implementation as ObjectInterfaceImplementation;
use ActiveCollab\Payments\TaxCategories\TaxCategoryInterface;
use InvalidArgumentException;

class TaxCategory implements TaxCategoryInterface
{
    use ObjectInterfaceImplementation;

    private $id = 1;

    private $tax_category;

    public function __construct(string $tax_category)
    {
        if (!in_array($tax_category, self::CATEGORIES)) {
            throw new InvalidArgumentException("Value '{$tax_category}' is not a valid tax category.");
        }

        $this->tax_category = $tax_category;
    }

    public function getId()
    {
        return $this->id;
    }

    public function &setId($value)
    {
        $this->id = $value;

        return $this;
    }

    public function getTaxCategory(): string
    {
        return $this->tax_category;
    }
}
