<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Customer;

use ActiveCollab\Payments\Address\AddressInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\PaymentMethod\PaymentMethodInterface;
use ActiveCollab\User\UserInterface;

/**
 * @package ActiveCollab\Payments\Customer
 */
interface CustomerInterface extends UserInterface
{
    /**
     * Return customer's reference in the payment gateway.
     *
     * @param  GatewayInterface $gateway
     * @return mixed
     */
    public function getReference(GatewayInterface $gateway);

    /**
     * Return our internal customer refernece (customer ID or code).
     *
     * @return mixed
     */
    public function getOurReference();

    /**
     * Return default payment method associated with this customer, or null if there is no such payment method.
     *
     * @return PaymentMethodInterface|null
     */
    public function getDefaultPaymentMethod();

    /**
     * Return all payment methods associated with this customer.
     *
     * @return PaymentMethodInterface[]
     */
    public function getPaymentMethods();

    /**
     * Create a new payment method based on the given list of arguments.
     *
     * @param  array                  $arguments
     * @return PaymentMethodInterface
     */
    public function createPaymentMethod(...$arguments);

    /**
     * Return customer's organisation name (company, non-profit etc).
     *
     * @return string
     */
    public function getOrganisationName();

    /**
     * Set customer's organisation name.
     *
     * @param  string $value
     * @return $this
     */
    public function &setOrganisationName($value);

    /**
     * Return customer's address.
     *
     * @return AddressInterface
     */
    public function getAddresss();

    /**
     * Set customer's address.
     *
     * @param  AddressInterface $value
     * @return $this
     */
    public function &setAddress(AddressInterface $value);

    /**
     * Return customer's phone number.
     *
     * @return string
     */
    public function getPhoneNumber();

    /**
     * Set phone number.
     *
     * @param  string $value
     * @return $this
     */
    public function &setPhoneNumber($value);
}
