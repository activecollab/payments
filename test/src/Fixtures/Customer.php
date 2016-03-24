<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Payments\Address\AddressInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\PaymentMethod\PaymentMethodInterface;
use ActiveCollab\User\AnonymousUser;
use BadMethodCallException;

/**
 * @package ActiveCollab\Payments\Customer
 */
class Customer extends AnonymousUser implements CustomerInterface
{
    /**
     * @var string
     */
    private $organisation_name = '';

    /**
     * @var string
     */
    private $address = '';

    /**
     * @var string
     */
    private $phone_number = '';

    /**
     * Return customer's reference in the payment gateway.
     *
     * @param  GatewayInterface $gateway
     * @return mixed
     */
    public function getReference(GatewayInterface $gateway)
    {
        return $this->getEmail();
    }

    /**
     * Return our internal customer refernece (customer ID or code).
     *
     * @return mixed
     */
    public function getOurReference()
    {
        return $this->getEmail();
    }

    /**
     * Return default payment method associated with this customer, or null if there is no such payment method.
     *
     * @return PaymentMethodInterface|null
     */
    public function getDefaultPaymentMethod()
    {
        return null;
    }

    /**
     * Return all payment methods associated with this customer.
     *
     * @return PaymentMethodInterface[]
     */
    public function getPaymentMethods()
    {
        return [];
    }

    /**
     * Create a new payment method based on the given list of arguments.
     *
     * @param  array                  $arguments
     * @return PaymentMethodInterface
     */
    public function createPaymentMethod(...$arguments)
    {
        throw new BadMethodCallException('Not implemented yet');
    }

    /**
     * Return customer's organisation name (company, non-profit etc).
     *
     * @return string
     */
    public function getOrganisationName()
    {
        return $this->organisation_name;
    }

    /**
     * Set customer's organisation name.
     *
     * @param  string $value
     * @return $this
     */
    public function &setOrganisationName($value)
    {
        $this->organisation_name = trim($value);

        return $this;
    }

    /**
     * Return customer's address.
     *
     * @return AddressInterface
     */
    public function getAddresss()
    {
        return $this->address;
    }

    /**
     * Set customer's address.
     *
     * @param  AddressInterface $value
     * @return $this
     */
    public function &setAddress(AddressInterface $value)
    {
        $this->address = $value;

        return $this;
    }

    /**
     * Return customer's phone number.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set phone number.
     *
     * @param  string $value
     * @return $this
     */
    public function &setPhoneNumber($value)
    {
        $this->phone_number = trim($value);

        return $this;
    }
}
