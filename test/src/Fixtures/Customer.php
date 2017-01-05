<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Payments\Address\CustomerAddressInterface;
use ActiveCollab\Payments\Customer\CustomerInterface;
use ActiveCollab\Payments\Gateway\GatewayInterface;
use ActiveCollab\Payments\PaymentMethod\PaymentMethodInterface;
use ActiveCollab\User\IdentifiedVisitor;
use BadMethodCallException;

/**
 * @package ActiveCollab\Payments\Customer
 */
class Customer extends IdentifiedVisitor implements CustomerInterface
{
    /**
     * @var string
     */
    private $organisation_name = '';

    /**
     * @var CustomerAddressInterface
     */
    private $address = '';

    /**
     * @var string
     */
    private $phone_number = '';

    /**
     * {@inheritdoc}
     */
    public function getReference(GatewayInterface $gateway)
    {
        return $this->getEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function getOurReference()
    {
        return $this->getEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultPaymentMethod(GatewayInterface $gateway): ?PaymentMethodInterface
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function listPaymentMethods(GatewayInterface $gateway): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function addPaymentMethod(GatewayInterface $gateway, bool $set_as_default, ...$arguments): PaymentMethodInterface
    {
        throw new BadMethodCallException('Not implemented yet');
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganisationName()
    {
        return $this->organisation_name;
    }

    /**
     * {@inheritdoc}
     */
    public function &setOrganisationName($value)
    {
        $this->organisation_name = trim($value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddresss(): CustomerAddressInterface
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function &setAddress(CustomerAddressInterface $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * {@inheritdoc}
     */
    public function &setPhoneNumber($value)
    {
        $this->phone_number = trim($value);

        return $this;
    }
}
