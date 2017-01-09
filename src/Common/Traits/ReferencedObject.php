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
    private $reference = '';

    public function getReference($context = null): string
    {
        return $this->reference;
    }

    /**
     * @param  string $reference
     * @return $this
     */
    public function &setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }
}
