<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Customer;

use ActiveCollab\Payments\Gateway\GatewayInterface;
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
     * @return string
     */
    public function getAddresss();

    /**
     * Set customer's address.
     *
     * @param  string $value
     * @return $this
     */
    public function &setAddress($value);

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
