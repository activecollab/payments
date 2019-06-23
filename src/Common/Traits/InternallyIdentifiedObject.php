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
trait InternallyIdentifiedObject
{
    /**
     * @var string
     */
    private $our_identifier = '';

    /**
     * Return our internal order indetifier (if present).
     *
     * @return string
     */
    public function getOurIdentifier(): string
    {
        return $this->our_identifier;
    }

    /**
     * Set our identifier.
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier(string $value)
    {
        $this->our_identifier = trim($value);

        return $this;
    }
}
