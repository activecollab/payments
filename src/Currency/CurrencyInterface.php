<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Currency;

use ActiveCollab\Object\ObjectInterface;

interface CurrencyInterface extends ObjectInterface
{
    public function getCode();

    public function getDecimalSpaces();

    public function getDecimalRounding();
}
