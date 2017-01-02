<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test;

use ActiveCollab\Payments\Test\Fixtures\Discount;
use ActiveCollab\Payments\Test\Fixtures\OrderItem;

class OrderItemCalculatorTest extends TestCase
{
    /**
     * @dataProvider productTaxCalculationData
     * @param float      $quantity
     * @param float      $unit_cost
     * @param float|null $discount_rate
     * @param float|null $first_tax_rate
     * @param float|null $second_tax_rate
     * @param bool|null  $second_tax_is_compound
     * @param float      $expected_subtotal
     * @param float      $expected_discount
     * @param float      $expected_first_tax
     * @param float      $expected_second_tax
     * @param float      $expected_tax
     * @param float      $expected_total
     */
    public function testCalculation(float $quantity, float $unit_cost, ?float $discount_rate, ?float $first_tax_rate, ?float $second_tax_rate, ?bool $second_tax_is_compound, float $expected_subtotal, float $expected_discount, float $expected_first_tax, float $expected_second_tax, float $expected_tax, float $expected_total)
    {
        $order_item = new OrderItem('A product', $quantity, $unit_cost, $first_tax_rate, $second_tax_rate, $second_tax_is_compound);

        if ($discount_rate) {
            $order_item->setDiscount(new Discount("{$discount_rate}% off", $discount_rate));
        }

        $calculation = $order_item->calculateAmounts();

        $this->assertSame($expected_subtotal, $calculation->getSubtotal());
        $this->assertSame($expected_discount, $calculation->getDiscount());
        $this->assertSame($expected_first_tax, $calculation->getFirstTax());
        $this->assertSame($expected_second_tax, $calculation->getSecondTax());
        $this->assertSame($expected_tax, $calculation->getTax());
        $this->assertSame($expected_total, $calculation->getTotal());
    }

    public function productTaxCalculationData()
    {
        return [

            // Basic calculation, no taxes, no discounts.
            [5, 100, null, null, null, null, 500.0, 0.0, 0.0, 0.0, 0.0, 500.0],

            // 25% discount on the entire item.
            [5, 100, 25, null, null, null, 500.0, 125.0, 0.0, 0.0, 0.0, 375.0],

            // First tax rate is 18%
            [5, 100, null, 18, null, null, 500.0, 0.0, 90.0, 0.0, 90.0, 590.0],

            // First tax rate is 18%, second tax rate is 5.5%, not compound.
            [5, 100, null, 18, 5.5, null, 500.0, 0.0, 90.0, 27.5, 117.5, 617.5],

            // First tax rate is 18%, second tax rate is 5.5%, and it is compound.
            [5, 100, null, 18, 5.5, true, 500.0, 0.0, 90.0, 32.45, 122.45, 622.45],
        ];
    }
}
