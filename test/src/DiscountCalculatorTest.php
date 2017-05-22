<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test;

use ActiveCollab\Payments\Discount\DiscountInterface;
use ActiveCollab\Payments\Test\Fixtures\Discount;

class DiscountCalculatorTest extends TestCase
{
    public function testPercentCalculator()
    {
        $this->assertSame(25.0, (new Discount('25% off', 25, DiscountInterface::TYPE_PERCENT))->calculateForAmount(100));
    }

    public function testPercentUpToMaxAmount()
    {
        $this->assertSame(100.0, (new Discount('25% off, up to $100', 25, DiscountInterface::TYPE_PERCENT, 100.0))->calculateForAmount(1000));
    }

    public function testAmountCalculator()
    {
        $this->assertSame(25.0, (new Discount('$25 off', 25, DiscountInterface::TYPE_VALUE))->calculateForAmount(100));
    }

    public function testAmountCantBeLargerThanOrderAmount()
    {
        $this->assertSame(5.0, (new Discount('$25 off', 25, DiscountInterface::TYPE_VALUE))->calculateForAmount(5));
    }
}
