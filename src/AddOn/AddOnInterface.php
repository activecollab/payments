<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\AddOn;

use ActiveCollab\Object\ObjectInterface;

/**
 * @package ActiveCollab\Payments\AddOn
 */
interface AddOnInterface extends ObjectInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getPrice(): string;
}
