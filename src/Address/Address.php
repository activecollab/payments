<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Address;

/**
 * @package ActiveCollab\Payments\Address
 */
class Address implements AddressInterface
{
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
     * Address constructor.
     *
     * @param string $address
     * @param string $address_extended
     * @param string $city
     * @param string $zip_code
     * @param string $region
     * @param string $country_code
     */
    public function __construct($address, $address_extended, $city, $zip_code, $region, $country_code)
    {
        $this->address = $address;
        $this->address_extended = $address_extended;
        $this->city = $city;
        $this->zip_code = $zip_code;
        $this->region = $region;
        $this->country_code = $country_code;
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
