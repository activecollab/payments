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
interface AddressInterface
{
    /**
     * @return string
     */
    public function getAddress();

    /**
     * @return string
     */
    public function getAddressExtended();

    /**
     * @return string
     */
    public function getCity();

    /**
     * @return string
     */
    public function getZipCode();

    /**
     * @return string
     */
    public function getRegion();

    /**
     * @return string
     */
    public function getCountryCode();
}
