<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\Traits;

/**
 * @package ActiveCollab\Payments\Traits
 */
trait Reference
{
    /**
     * @var string
     */
    private $reference;

    /**
     * Return parent reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
}
