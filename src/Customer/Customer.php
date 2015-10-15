<?php

namespace ActiveCollab\Payments\Customer;

use ActiveCollab\User\AnonymousUser;

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
     * Return customer's organisation name (company, non-profit etc)
     *
     * @return string
     */
    public function getOrganisationName()
    {
        return $this->organisation_name;
    }

    /**
     * Set customer's organisation name
     *
     * @param  string $value
     * @return $this
     */
    public function &setOrganisationName($value)
    {
        $this->organisation_name = trim($value);
    }

    /**
     * Return customer's address
     *
     * @return string
     */
    public function getAddresss()
    {
        return $this->address;
    }

    /**
     * Set customer's address
     *
     * @param  string $value
     * @return $this
     */
    public function &setAddress($value)
    {
        $this->address = (string) $value;

        return $this;
    }

    /**
     * Return customer's phone number
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set phone number
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
