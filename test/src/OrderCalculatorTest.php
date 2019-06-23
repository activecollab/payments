<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test;

use ActiveCollab\DateValue\DateTimeValue;
use ActiveCollab\Payments\Test\Fixtures\Customer;
use ActiveCollab\Payments\Test\Fixtures\Order;
use ActiveCollab\Payments\Test\Fixtures\OrderItem;

class OrderCalculatorTest extends TestCase
{
    public function testCalculateOrder()
    {
        $customer = new Customer('John Doe', 'john.doe@example.com');

        $apples = new OrderItem('Apples', 5, 1.25, 18.0, 5.5);
        $oranges = new OrderItem('Oranges', 12, 1.75, 18.0);

        $order = new Order($customer, '2017/01', new DateTimeValue(), 'USD', [
            $apples,
            $oranges,
        ]);

        $this->assertSame(27.25, $order->getSubtotalAmount());
        $this->assertSame(0.0, $order->getDiscountAmount());
        $this->assertSame(4.91, $order->getFirstTaxAmount());
        $this->assertSame(0.34, $order->getSecondTaxAmount());
        $this->assertSame(32.5, $order->getTotalAmount());
    }
}
