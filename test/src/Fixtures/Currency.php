<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Test\Fixtures;

use ActiveCollab\Payments\Currency\CurrencyInterface;

class Currency implements CurrencyInterface
{
    private $code;

    private $decimal_spaces;

    private $decimal_rounding;

    public function __construct(string $code, int $decimal_spaces = 2, float $decimal_rounding = 0.0)
    {
        $this->code = $code;
        $this->decimal_spaces = $decimal_spaces;
        $this->decimal_rounding = $decimal_rounding;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDecimalSpaces(): int
    {
        return $this->decimal_spaces;
    }

    public function getDecimalRounding(): float
    {
        return $this->decimal_rounding;
    }
}
