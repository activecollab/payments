<?php

namespace ActiveCollab\Payments\Customer;

use ActiveCollab\User\UserInterface;

/**
 * @package ActiveCollab\Payments\Customer
 */
interface CustomerInterface extends UserInterface
{
    /**
     * Return customer's organisation name (company, non-profit etc)
     *
     * @return string
     */
    public function getOrganisationName();

    /**
     * Set customer's organisation name
     *
     * @param  string $value
     * @return $this
     */
    public function &setOrganisationName($value);

    /**
     * Return customer's address
     *
     * @return string
     */
    public function getAddresss();

    /**
     * Set customer's address
     *
     * @param  string $value
     * @return $this
     */
    public function &setAddress($value);

    /**
     * Return customer's phone number
     *
     * @return string
     */
    public function getPhoneNumber();

    /**
     * Set phone number
     *
     * @param  string $value
     * @return $this
     */
    public function &setPhoneNumber($value);
}
