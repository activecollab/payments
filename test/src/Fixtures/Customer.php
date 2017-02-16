<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Payments\Address\AddressInterface;
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
     * @var AddressInterface|null
     */
    private $address;

    private $phone_number = '';

    public function getReference(): string
    {
        return $this->getEmail();
    }

    public function getOurIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getDefaultPaymentMethod(): ?PaymentMethodInterface
    {

    }

    public function getDefaultGatewayPaymentMethod(GatewayInterface $gateway): ?PaymentMethodInterface
    {
        return null;
    }

    public function getPaymentMethods(): ?iterable
    {
        return [];
    }

    public function getGatewayPaymentMethods(GatewayInterface $gateway): ?iterable
    {
        return [];
    }

    public function addPaymentMethod(GatewayInterface $gateway, ?AddressInterface $address, bool $set_as_default, ...$arguments): PaymentMethodInterface
    {
        throw new BadMethodCallException('Not implemented yet');
    }

    public function getAddress(): ?AddressInterface
    {
        return $this->address;
    }

    /**
     * @param  AddressInterface|null   $address
     * @return CustomerInterface|$this
     */
    public function &setAddress(AddressInterface $address = null): CustomerInterface
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
