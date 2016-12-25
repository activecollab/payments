<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare (strict_types = 1);

namespace ActiveCollab\Payments\Address;

/**
 * @package ActiveCollab\Payments\Address
 */
class Address implements AddressInterface
{
    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $company_name;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $address_extended;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $zip_code;

    /**
     * @var string
     */
    private $region;

    /**
     * @var string
     */
    private $country_code;

    /**
     * @var string
     */
    private $tax_id;

    /**
     * Address constructor.
     *
     * @param string $first_name
     * @param string $last_name
     * @param string $company_name
     * @param string $address
     * @param string $address_extended
     * @param string $city
     * @param string $zip_code
     * @param string $region
     * @param string $country_code
     * @param string $tax_id
     */
    public function __construct($first_name, $last_name, $company_name, $address, $address_extended, $city, $zip_code, $region, $country_code, $tax_id = '')
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->company_name = $company_name;
        $this->address = $address;
        $this->address_extended = $address_extended;
        $this->city = $city;
        $this->zip_code = $zip_code;
        $this->region = $region;
        $this->country_code = $country_code;
        $this->tax_id = $tax_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddressExtended()
    {
        return $this->address_extended;
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * {@inheritdoc}
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountryCode()
    {
        return $this->getCountryCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxId()
    {
        return $this->tax_id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = $this->getAddress();

        if ($this->getAddressExtended()) {
            $result .= "\n" . $this->getAddressExtended();
        }

        if ($this->getRegion()) {
            $result .= "\n" . trim($this->getCity() . ' ' . $this->getRegion() . ' ' . $this->getZipCode());
        } else {
            $result .= "\n" . trim($this->getCity() . ' ' . $this->getZipCode());
        }

        $result .= "\n" . $this->getCountryCode();

        return trim($result);
    }
}
