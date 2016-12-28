<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Common\Traits;

/**
 * @package ActiveCollab\Payments\Traits
 */
trait ReferencedObject
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
