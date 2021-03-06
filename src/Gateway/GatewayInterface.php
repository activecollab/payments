<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Gateway;

use ActiveCollab\Payments\Address\AddressInterface;
use ActiveCollab\Payments\Common\InternallyIdentifiedObjectInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\PaymentMethod\PaymentMethodInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;
use ActiveCollab\User\UserInterface;

/**
 * @package ActiveCollab\Payments
 */
interface GatewayInterface extends InternallyIdentifiedObjectInterface
{
    /**
     * Return dispatcher instance.
     *
     * @return DispatcherInterface
     */
    public function getDispatcher(): DispatcherInterface;

    /**
     * Return gateway identifier.
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Create a payment method for the given customer and return the instance.
     *
     * @param  CustomerInterface      $customer
     * @param  AddressInterface|null  $address
     * @param  bool                   $set_as_default
     * @param  array                  $arguments
     * @return PaymentMethodInterface
     */
    public function addPaymentMethod(
        CustomerInterface $customer,
        ?AddressInterface $address,
        bool $set_as_default,
        ...$arguments
    ): PaymentMethodInterface;

    /**
     * @param  PaymentMethodInterface $payment_method
     * @param  CustomerInterface      $customer
     * @param  AddressInterface|null  $address
     * @param  array                  $arguments
     * @return PaymentMethodInterface
     */
    public function updatePaymentMethod(
        PaymentMethodInterface $payment_method,
        CustomerInterface $customer,
        ?AddressInterface $address,
        ...$arguments
    ): PaymentMethodInterface;

    /**
     * @param  PaymentMethodInterface      $payment_method
     * @return PaymentMethodInterface|null
     */
    public function removePaymentMethod(PaymentMethodInterface $payment_method): ?PaymentMethodInterface;

    /**
     * Return order by order ID.
     *
     * @param  string         $order_reference
     * @return OrderInterface
     */
    public function getOrderByReference(string $order_reference): OrderInterface;

    /**
     * Return refund by refund ID.
     *
     * @param  string          $refund_reference
     * @return RefundInterface
     */
    public function getRefundByReference(string $refund_reference): RefundInterface;

    public function createCharge(
        CustomerInterface $customer,
        PaymentMethodInterface $payment_method,
        string $product_name,
        float $total_amount,
        float $discount_amount = null,
        float $tax_amount = null
    ): string;

    public function createSubscription(
        CustomerInterface $customer,
        PaymentMethodInterface $payment_method,
        string $product_name,
        string $period,
        ...$arguments
    ): string;

    public function updateSubscription(
        SubscriptionInterface $subscription,
        CustomerInterface $customer,
        PaymentMethodInterface $payment_method,
        string $product_name,
        string $period,
        ...$arguments
    ): void;

    public function cancelSubscription(
        SubscriptionInterface $subscription,
        ...$arguments
    ): void;

    /**
     * Return subscription by subscription ID.
     *
     * @param  string                $subscription_reference
     * @return SubscriptionInterface
     */
    public function getSubscriptionByReference(string $subscription_reference): SubscriptionInterface;

    /**
     * Return product ID based on product name (or code) and billing period.
     *
     * @param  string $product_name
     * @param  string $period
     * @return string
     */
    public function getProductIdByNameAndBillingPeriod(
        string $product_name,
        string $period = SubscriptionInterface::BILLING_PERIOD_MONTHLY
    ): string;

    /**
     * Return add-on ID based on add-on name (or code).
     *
     * @param  string $name
     * @return string
     */
    public function getAddOnIdByName(string $name): string;

    /**
     * Return discount ID based on discount name (or code).
     *
     * @param  string $name
     * @return string
     */
    public function getDiscountIdByName(string $name): string;

    /**
     * Execute order.
     *
     * @param  OrderInterface $order
     * @param  UserInterface  $by
     * @return OrderInterface
     */
    public function executeOrder(OrderInterface $order, UserInterface $by = null): OrderInterface;

    /**
     * Return if gateway can execute order.
     *
     * @param  OrderInterface $order
     * @return bool
     */
    public function canExecuteOrder(OrderInterface $order): bool;
}
