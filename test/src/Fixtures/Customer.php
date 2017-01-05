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
     * @var CustomerAddressInterface|null
     */
    private $address;

    private $phone_number = '';

    public function getReference(GatewayInterface $gateway)
    {
        return $this->getEmail();
    }

    public function getOurReference()
    {
        return $this->getEmail();
    }

    public function getDefaultPaymentMethod(GatewayInterface $gateway): ?PaymentMethodInterface
    {
        return null;
    }

    public function listPaymentMethods(GatewayInterface $gateway): array
    {
        return [];
    }

    public function addPaymentMethod(GatewayInterface $gateway, bool $set_as_default, ...$arguments): PaymentMethodInterface
    {
        throw new BadMethodCallException('Not implemented yet');
    }

    public function getAddresss(): ?CustomerAddressInterface
    {
        return $this->address;
    }

    /**
     * @param  CustomerAddressInterface|null $address
     * @return CustomerInterface|$this
     */
    public function &setAddress(CustomerAddressInterface $address = null): CustomerInterface
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    /**
     * @param  string|null             $value
     * @return CustomerInterface|$this
     */
    public function &setPhoneNumber(string $value = null): CustomerInterface
    {
        $this->phone_number = trim($value);

        return $this;
    }
}
