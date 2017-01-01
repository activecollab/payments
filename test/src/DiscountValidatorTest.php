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

class DiscountValidatorTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Discount name is required.
     */
    public function testValidateName()
    {
        new Discount('', 10, DiscountInterface::PERCENT);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Valid discount type is required.
     */
    public function testInvalidType()
    {
        new Discount('Discount', 10, 'not a valid discount type');
    }

    /**
     * @dataProvider provideInvalidDiscountRates
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Discount rate greather than 0 and lower or equal to 100 percent is required.
     * @param float $invalid_discount_rate
     */
    public function testInvalidValueForPercent(float $invalid_discount_rate)
    {
        new Discount('Invalid discount', $invalid_discount_rate, DiscountInterface::PERCENT);
    }

    public function provideInvalidDiscountRates(): array
    {
        return [
            [-15],
            [-0.25],
            [0],
            [100.01],
            [115],
        ];
    }

    /**
     * @dataProvider provideInvalidDiscountAmounts
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Discount amount greather than 0 is required.
     * @param float $invalid_discount_amount
     */
    public function testInvalidValueForAmount(float $invalid_discount_amount)
    {
        new Discount('Invalid discount', $invalid_discount_amount, DiscountInterface::VALUE);
    }

    public function provideInvalidDiscountAmounts(): array
    {
        return [
            [-15],
            [-0.25],
            [0]
        ];
    }

    /**
     * @dataProvider provideInvalidMaxAmount
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Maximum discount amount can be NULL or amount larger than 0.
     * @param float $invalid_max_amount
     */
    public function testInvalidMaxValue(float $invalid_max_amount)
    {
        new Discount('No discount', 5, DiscountInterface::PERCENT, $invalid_max_amount);
    }

    public function provideInvalidMaxAmount(): array
    {
        return [
            [-15],
            [-0.25],
            [0]
        ];
    }
}
