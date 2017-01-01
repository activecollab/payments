<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Discount\Traits;

use ActiveCollab\Payments\Discount\DiscountInterface;
use InvalidArgumentException;
use LogicException;

trait DiscountValidator
{
    protected function validateDiscountName(string $name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Discount name is required.');
        }
    }

    protected function validateDiscountType(string $type)
    {
        if (!in_array($type, DiscountInterface::DISCOUNT_TYPES)) {
            throw new InvalidArgumentException('Valid discount type is required.');
        }
    }

    protected function validateDiscountValue(string $type, float $value)
    {
        if ($type === DiscountInterface::PERCENT) {
            if ($value <= 0 || $value > 100) {
                throw new InvalidArgumentException('Discount rate greather than 0 and lower or equal to 100 percent is required.');
            }
        } else {
            if ($value <= 0) {
                throw new InvalidArgumentException('Discount amount greather than 0 is required.');
            }
        }
    }

    protected function validateMaxDiscountAmount(string $type, ?float $max_amount)
    {
        if ($max_amount !== null) {
            if ($type === DiscountInterface::VALUE) {
                throw new LogicException('Max amount is available only for percent discounts.');
            }

            if ($max_amount <= 0) {
                throw new InvalidArgumentException('Maximum discount amount can be NULL or amount larger than 0.');
            }
        }
    }
}
