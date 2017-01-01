<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test;

use ActiveCollab\DateValue\DateTimeValue;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Test\Fixtures\Customer;
use ActiveCollab\Payments\Test\Fixtures\OrderItem;
use ActiveCollab\Payments\Test\Fixtures\Subscription;

/**
 * @package ActiveCollab\Payments\Test
 */
class SubscriptionTest extends TestCase
{
    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var DateTimeValue
     */
    protected $timestamp;

    /**
     * Set up test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->customer = new Customer('John Doe', 'john@example.com');
        $this->timestamp = new DateTimeValue('2015-10-15');
    }

    /**
     * Tear down test environment.
     */
    public function tearDown()
    {
        $this->customer = $this->timestamp = null;

        parent::tearDown();
    }

    /**
     * Test if next billing date can be explicitely set, regardless of period.
     */
    public function testNextBillingCanBeSet()
    {
        $monthly_subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::MONTHLY, 'USD', 25, [
            new OrderItem('SaaS', 1, 25),
        ]);
        $monthly_subscription->setNextBillingTimestamp(new DateTimeValue('2015-11-11'));

        $next_billing_timestamp = $monthly_subscription->getNextBillingTimestamp();

        $this->assertInstanceOf(DateTimeValue::class, $next_billing_timestamp);
        $this->assertEquals('2015-11-11', $next_billing_timestamp->format('Y-m-d'));

        $yearly_subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::YEARLY, 'USD', 25, [
            new OrderItem('SaaS', 1, 25),
        ]);
        $yearly_subscription->setNextBillingTimestamp(new DateTimeValue('2015-12-13'));

        $next_billing_timestamp = $yearly_subscription->getNextBillingTimestamp();

        $this->assertInstanceOf(DateTimeValue::class, $next_billing_timestamp);
        $this->assertEquals('2015-12-13', $next_billing_timestamp->format('Y-m-d'));
    }

    /**
     * Test if next monthly billing date is automatically calculated when not explicitely set.
     */
    public function testNextBillingOnForMonthlySubscription()
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::MONTHLY, 'USD', 25, [
            new OrderItem('SaaS', 1, 25),
        ]);

        $next_billing_timestamp = $subscription->getNextBillingTimestamp();

        $this->assertInstanceOf(DateTimeValue::class, $next_billing_timestamp);
        $this->assertEquals('2015-11-15', $next_billing_timestamp->format('Y-m-d'));
    }

    /**
     * Test if next yearly billing date is automatically calculated when not explicitely set.
     */
    public function testNextBillingOnForYearlySubscription()
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::YEARLY, 'USD', 25, [
            new OrderItem('SaaS', 1, 25),
        ]);

        $next_billing_timestamp = $subscription->getNextBillingTimestamp();

        $this->assertInstanceOf(DateTimeValue::class, $next_billing_timestamp);
        $this->assertEquals('2016-10-15', $next_billing_timestamp->format('Y-m-d'));
    }
}
