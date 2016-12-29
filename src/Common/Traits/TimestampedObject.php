<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Common\Traits;

use ActiveCollab\DateValue\DateTimeValueInterface;

/**
 * @package ActiveCollab\Payments\Traits
 */
trait TimestampedObject
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

    /**
     * @param  DateTimeValueInterface $timestamp
     * @return $this
     */
    public function &setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
