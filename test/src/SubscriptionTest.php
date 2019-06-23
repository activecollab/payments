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
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\Payments\Test\Fixtures\Customer;
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
        $monthly_subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_MONTHLY);
        $monthly_subscription->setNextBillingTimestamp(new DateTimeValue('2015-11-11'));

        $next_billing_timestamp = $monthly_subscription->getNextBillingTimestamp();

        $this->assertInstanceOf(DateTimeValue::class, $next_billing_timestamp);
        $this->assertEquals('2015-11-11', $next_billing_timestamp->format('Y-m-d'));

        $yearly_subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_YEARLY);
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
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_MONTHLY);

        $next_billing_timestamp = $subscription->getNextBillingTimestamp();

        $this->assertInstanceOf(DateTimeValue::class, $next_billing_timestamp);
        $this->assertEquals('2015-11-15', $next_billing_timestamp->format('Y-m-d'));
    }

    /**
     * Test if next yearly billing date is automatically calculated when not explicitely set.
     */
    public function testNextBillingOnForYearlySubscription()
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_YEARLY);

        $next_billing_timestamp = $subscription->getNextBillingTimestamp();

        $this->assertInstanceOf(DateTimeValue::class, $next_billing_timestamp);
        $this->assertEquals('2016-10-15', $next_billing_timestamp->format('Y-m-d'));
    }

    /**
     * @dataProvider provideSubscriptionStatusesActivationMap
     * @param string $status
     * @param bool   $can_be_activated
     */
    public function testSubscriptionsCanBeActivated($status, bool $can_be_activated)
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_YEARLY);
        $subscription->setStatus($status);

        $this->assertSame($can_be_activated, $subscription->canBeActivated());
    }

    public function provideSubscriptionStatusesActivationMap()
    {
        return [
            [SubscriptionInterface::STATUS_PENDING, true],
            [SubscriptionInterface::STATUS_ACTIVE, false],
            [SubscriptionInterface::STATUS_CANCELED, false],
            [SubscriptionInterface::STATUS_DEACTIVATED, false],
        ];
    }

    /**
     * @dataProvider provideSubscriptionStatusesCancelationMap
     * @param string $status
     * @param bool   $can_be_activated
     */
    public function testSubscriptionsCanBeCanceled($status, bool $can_be_activated)
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_YEARLY);
        $subscription->setStatus($status);

        $this->assertSame($can_be_activated, $subscription->canBeCanceled());
    }

    public function provideSubscriptionStatusesCancelationMap()
    {
        return [
            [SubscriptionInterface::STATUS_PENDING, false],
            [SubscriptionInterface::STATUS_ACTIVE, true],
            [SubscriptionInterface::STATUS_CANCELED, false],
            [SubscriptionInterface::STATUS_DEACTIVATED, true],
        ];
    }

    /**
     * @dataProvider provideSubscriptionStatusesDectivationMap
     * @param string $status
     * @param bool   $can_be_activated
     */
    public function testSubscriptionsCanBeDectivated($status, bool $can_be_activated)
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_YEARLY);
        $subscription->setStatus($status);

        $this->assertSame($can_be_activated, $subscription->canBeDeactivated());
    }

    public function provideSubscriptionStatusesDectivationMap()
    {
        return [
            [SubscriptionInterface::STATUS_PENDING, false],
            [SubscriptionInterface::STATUS_ACTIVE, true],
            [SubscriptionInterface::STATUS_CANCELED, false],
            [SubscriptionInterface::STATUS_DEACTIVATED, false],
        ];
    }

    public function testPendingSubscriptionCanBePurchased()
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_YEARLY);
        $subscription->setStatus(SubscriptionInterface::STATUS_PENDING);

        $this->assertTrue($subscription->canBePurchased());
    }

    /**
     * @dataProvider provideNonPurchasableStatuses
     * @param string $non_purchasable_status
     */
    public function testNonPurchasableSubscfriptionStatuses(string $non_purchasable_status)
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_YEARLY);
        $subscription->setStatus($non_purchasable_status);

        $this->assertFalse($subscription->canBePurchased());
    }

    public function provideNonPurchasableStatuses()
    {
        return [
            [SubscriptionInterface::STATUS_ACTIVE],
            [SubscriptionInterface::STATUS_DEACTIVATED],
            [SubscriptionInterface::STATUS_CANCELED],
        ];
    }

    public function testPaidSubscriptionsCanBePurchased()
    {
        $subscription = new Subscription($this->customer, '123', $this->timestamp, Subscription::BILLING_PERIOD_YEARLY);
        $subscription->setStatus(SubscriptionInterface::STATUS_PENDING);

        $this->assertFalse($subscription->isFree());
        $this->assertTrue($subscription->canBePurchased());

        $subscription->setIsFree(true);
        $this->assertFalse($subscription->canBePurchased());
    }
}
