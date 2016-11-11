<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\Gateway;

use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Dispatcher\DispatcherInterface;
use ActiveCollab\Payments\Order\OrderInterface;
use ActiveCollab\Payments\Order\Refund\RefundInterface;
use ActiveCollab\Payments\PaymentMethod\PaymentMethodInterface;
use ActiveCollab\Payments\Subscription\SubscriptionInterface;

/**
 * @package ActiveCollab\Payments
 */
interface GatewayInterface
{
    /**
     * Return dispatcher instance.
     *
     * @return DispatcherInterface
     */
    public function &getDispatcher(): DispatcherInterface;

    /**
     * @param  DispatcherInterface $gateway
     * @return GatewayInterface
     */
    public function &setDispatcher(DispatcherInterface $gateway): GatewayInterface;

    /**
     * Return gateway identifier.
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Return our gateway reference (ID).
     *
     * @return string
     */
    public function getOurReference(): string;

    /**
     * Return default payment method for the given customer.
     *
     * @param  string                      $customer_id
     * @return PaymentMethodInterface|null
     */
    public function getDefaultPaymentMethod(string $customer_id);

    /**
     * Return an array of payment methods that we have stored for the given customer.
     *
     * @param  string                   $customer_id
     * @return PaymentMethodInterface[]
     */
    public function listPaymentMethods(string $customer_id): array;

    /**
     * Create a payment method for the given customer and return the instance.
     *
     * @param  CustomerInterface      $customer
     * @param  bool                   $set_as_default
     * @param  array                  $arguments
     * @return PaymentMethodInterface
     */
    public function addPaymentMethod(CustomerInterface $customer, bool $set_as_default, ...$arguments): PaymentMethodInterface;

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

    /**
     * Create a new subscription for the given customer that ordered a given product using a given payment method.
     *
     * @param  CustomerInterface      $customer
     * @param  PaymentMethodInterface $payment_method
     * @param  string                 $product_name
     * @param  string                 $period
     * @param  mixed                  $arguments
     * @return SubscriptionInterface
     */
    public function createSubscription(CustomerInterface $customer, PaymentMethodInterface $payment_method, $product_name, string $period, ...$arguments): SubscriptionInterface;

    /**
     * Update an existing interface for the given customer, that ordered a given product using a given payment method.
     *
     * @param SubscriptionInterface  $subscription
     * @param CustomerInterface      $customer
     * @param PaymentMethodInterface $payment_method
     * @param                        $product_name
     * @param string                 $period
     * @param array                  ...$arguments
     * @return SubscriptionInterface
     */
    public function updateSubscription(SubscriptionInterface $subscription, CustomerInterface $customer, PaymentMethodInterface $payment_method, $product_name, string $period, ...$arguments):SubscriptionInterface;

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
    public function getProductIdByNameAndBillingPeriod(string $product_name, string $period = SubscriptionInterface::MONTHLY): string;
}
