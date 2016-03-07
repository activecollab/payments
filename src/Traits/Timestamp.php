<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Traits;

use ActiveCollab\DateValue\DateTimeValueInterface;

/**
 * @package ActiveCollab\Payments\Traits
 */
trait Timestamp
{
    /**
     * @var DateTimeValueInterface
     */
    private $timestamp;

    /**
     * Return date and time when this order was made.
     *
     * @return DateTimeValueInterface
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
